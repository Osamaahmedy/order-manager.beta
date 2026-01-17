<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Resident extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'branch_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        // عند إنشاء مقيم جديد، تسجيل الاستخدام
        static::created(function ($resident) {
            $admin = $resident->branch?->admins()->first();
            if ($admin && $subscription = $admin->subscription()) {
                $subscription->recordUsage('residents', 1);
            }
        });

        // منع تسجيل الدخول إذا كان المقيم غير نشط
        static::retrieved(function ($resident) {
            if (!$resident->is_active && auth()->guard('api')->check()) {
                abort(403, 'حسابك معطل. يرجى التواصل مع الإدارة');
            }
        });
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * للبحث بالهاتف بدلاً من Email
     */
    public function findForPassport($username)
    {
        return $this->where('phone', $username)
            ->where('is_active', true)
            ->first();
    }

    /**
     * scope للمقيمين النشطين فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * الحصول على الـ Admin المسؤول
     */
    public function getAdmin()
    {
        return $this->branch?->admins()->first();
    }

    /**
     * التحقق من أن المقيم تابع لـ admin مشترك
     */
    public function hasActiveSubscription(): bool
    {
        $admin = $this->getAdmin();
        return $admin && $admin->subscribed();
    }
}
