<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'interval',
        'max_branches', 'max_residents', 'max_orders_per_month',
        'features', 'is_active', 'trial_days'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    public function getIntervalInArabic(): string
    {
        return match($this->interval) {
            'monthly' => 'شهري',
            'yearly' => 'سنوي',
            'lifetime' => 'مدى الحياة',
            default => $this->interval,
        };
    }
}
