<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'plan_id',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
        'status'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updated(function ($subscription) {
            if ($subscription->isDirty('status') &&
                in_array($subscription->status, ['expired', 'canceled', 'suspended'])) {
                $subscription->deactivateAdminResources();
            }

            if ($subscription->isDirty('status') && $subscription->status === 'active') {
                $subscription->activateAdminResources();
            }
        });
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function usage()
    {
        return $this->hasMany(SubscriptionUsage::class);
    }

    // ✅ الحل: تحديث isActive() لتشمل الفترة التجريبية
    public function isActive(): bool
    {
        // إذا الحالة مو active، يعني منتهي
        if ($this->status !== 'active') {
            return false;
        }

        // إذا في فترة تجريبية نشطة
        if ($this->onTrial()) {
            return true;
        }

        // إذا مافي تاريخ انتهاء (lifetime)
        if (!$this->ends_at) {
            return true;
        }

        // التحقق من تاريخ الانتهاء
        return $this->ends_at->isFuture();
    }

    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    // ✅ الحل: التحقق من الانتهاء (يشمل التجريبي)
    public function hasEnded(): bool
    {
        // إذا في فترة تجريبية لسا شغالة
        if ($this->onTrial()) {
            return false;
        }

        // إذا مافي ends_at (lifetime)
        if (!$this->ends_at) {
            return false;
        }

        // التحقق من تاريخ الانتهاء
        return $this->ends_at->isPast();
    }

    // ✅ الحل: حساب الأيام المتبقية (يشمل التجريبي)
    public function daysRemaining(): int
{
    // ✅ إذا في فترة تجريبية نشطة، احسب من trial_ends_at
    if ($this->onTrial() && $this->trial_ends_at) {
        $days = now()->diffInDays($this->trial_ends_at, false);
        return (int) ceil($days); // التقريب للأعلى
    }

    // إذا مافي ends_at (lifetime)
    if (!$this->ends_at) {
        return -1; // غير محدود
    }

    // حساب الأيام المتبقية للاشتراك العادي
    $days = now()->diffInDays($this->ends_at, false);
    return (int) ceil($days);
}
    // ✅ إضافة: معرفة التاريخ الفعلي للانتهاء
    public function getEffectiveEndsAt()
    {
        if ($this->onTrial()) {
            return $this->trial_ends_at;
        }

        return $this->ends_at;
    }

    public function recordUsage(string $feature, int $amount = 1)
    {
        $usage = $this->usage()
            ->where('feature', $feature)
            ->whereDate('reset_at', '>=', now())
            ->first();

        if (!$usage) {
            $usage = $this->usage()->create([
                'feature' => $feature,
                'used' => 0,
                'reset_at' => now()->endOfMonth(),
            ]);
        }

        $usage->increment('used', $amount);
        return $usage;
    }

    public function getUsage(string $feature): int
    {
        return $this->usage()
            ->where('feature', $feature)
            ->whereDate('reset_at', '>=', now())
            ->value('used') ?? 0;
    }

    public function canUseFeature(string $feature, int $amount = 1): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        $limit = $this->plan->{"max_$feature"};
        if (!$limit) return true;

        $used = $this->getUsage($feature);
        return ($used + $amount) <= $limit;
    }

    public function getRemainingQuota(string $feature): int|string
    {
        $limit = $this->plan->{"max_$feature"};
        if (!$limit) return 'غير محدود';

        $used = $this->getUsage($feature);
        return max(0, $limit - $used);
    }

    public function deactivateAdminResources()
    {
        $this->admin->branches()->update(['is_active' => false]);

        $branchIds = $this->admin->branches()->pluck('branches.id');
        Resident::whereIn('branch_id', $branchIds)->update(['is_active' => false]);

        Log::info("تم تعطيل موارد Admin #{$this->admin_id} بسبب انتهاء الاشتراك");
    }

    public function activateAdminResources()
    {
        $maxBranches = $this->plan->max_branches ?? PHP_INT_MAX;
        $this->admin->branches()
            ->limit($maxBranches)
            ->update(['is_active' => true]);

        $branchIds = $this->admin->branches()
            ->where('is_active', true)
            ->pluck('branches.id');

        $maxResidents = $this->plan->max_residents ?? PHP_INT_MAX;
        Resident::whereIn('branch_id', $branchIds)
            ->limit($maxResidents)
            ->update(['is_active' => true]);

        Log::info("تم تفعيل موارد Admin #{$this->admin_id} بعد تجديد الاشتراك");
    }

    public function suspend(string $reason = null)
    {
        $this->update(['status' => 'suspended']);
        $this->deactivateAdminResources();

        event(new \App\Events\SubscriptionSuspended($this, $reason));
    }

    public function resume()
    {
        if ($this->hasEnded()) {
            throw new \Exception('لا يمكن استئناف اشتراك منتهي');
        }

        $this->update(['status' => 'active']);
        $this->activateAdminResources();

        event(new \App\Events\SubscriptionResumed($this));
    }
}
