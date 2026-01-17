<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        // عند إنشاء فرع جديد، تسجيل الاستخدام
        static::created(function ($branch) {
            $admin = $branch->admins()->first();
            if ($admin && $subscription = $admin->subscription()) {
                $subscription->recordUsage('branches', 1);
            }
        });

        // منع الحذف إذا كان هناك مقيم نشط
        static::deleting(function ($branch) {
            if ($branch->resident && $branch->resident->is_active) {
                throw new \Exception('لا يمكن حذف فرع يحتوي على مقيم نشط');
            }
        });
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_branch')
            ->withTimestamps();
    }

    public function resident(): HasOne
    {
        return $this->hasOne(Resident::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * scope للفروع النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * التحقق من أن الفرع تابع لـ admin مشترك
     */
    public function hasActiveSubscription(): bool
    {
        return $this->admins()
            ->get()
            ->contains(fn($admin) => $admin->subscribed());
    }
}
