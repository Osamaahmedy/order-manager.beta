<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'order_number',
        'number',
        'resident_id',
        'branch_id',
        'status',
        'notes',
        'submitted_at',
        'delivery_app_id',
        'created_by_type',
        'created_by_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * =========================
     * BOOT
     * =========================
     */
    protected static function boot()
    {
        parent::boot();

        // قبل الإنشاء: ضبط الفرع من المقيم (إن وجد)
        static::creating(function ($order) {
            if (empty($order->branch_id) && !empty($order->resident_id)) {
                $resident = Resident::find($order->resident_id);
                if ($resident) {
                    $order->branch_id = $resident->branch_id;
                }
            }
        });

        // بعد الإنشاء: توليد رقم الطلب من ID (مضمون ولا يتكرر)
        static::created(function ($order) {
            if (empty($order->order_number)) {
                $order->updateQuietly([
                    'order_number' => self::generateOrderNumber($order->id),
                ]);
            }
        });
    }

    /**
     * توليد رقم الطلب من الـ ID
     * مثال: ORD-2026-000123
     */
    protected static function generateOrderNumber(int $id): string
    {
        return 'ORD-' . date('Y') . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * =========================
     * RELATIONS
     * =========================
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function deliveryApp(): BelongsTo
    {
        return $this->belongsTo(DeliveryApp::class);
    }

    /**
     * من أنشأ الطلب (Admin أو Resident)
     */
    public function createdBy(): MorphTo
    {
        return $this->morphTo('created_by');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');
        $this->addMediaCollection('videos')->useDisk('public');
    }

    /**
     * Helpers
     */
    public function isCreatedByAdmin(): bool
    {
        return $this->created_by_type === Admin::class;
    }

    public function isCreatedByResident(): bool
    {
        return $this->created_by_type === Resident::class;
    }
}
