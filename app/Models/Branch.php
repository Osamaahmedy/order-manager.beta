<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_branch')
            ->withTimestamps();
    }

    // تغيير من hasOne إلى hasMany
    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->admins()
            ->get()
            ->contains(fn($admin) => $admin->subscribed());
    }

    // دالة مساعدة للحصول على المقيمين النشطين فقط
    public function activeResidents()
    {
        return $this->residents()->where('is_active', true);
    }
}
