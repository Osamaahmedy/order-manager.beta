<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable implements FilamentUser
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * علاقة الاشتراكات
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * الاشتراك النشط الحالي
     */
    public function subscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    /**
     * التحقق من وجود اشتراك نشط
     */
    public function subscribed(?string $planName = null): bool
    {
        $subscription = $this->subscription();

        if (!$subscription || !$subscription->isActive()) {
            return false;
        }

        if ($planName) {
            return $subscription->plan->name === $planName;
        }

        return true;
    }

    /**
     * إنشاء اشتراك جديد
     */
    public function subscribe(Plan $plan, bool $withTrial = false): Subscription
    {
        // إلغاء الاشتراكات النشطة السابقة
        $this->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'canceled', 'canceled_at' => now()]);

        $subscription = new Subscription([
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'status' => 'active',
        ]);

        if ($withTrial && $plan->trial_days > 0) {
            $subscription->trial_ends_at = now()->addDays($plan->trial_days);
        }

        if ($plan->interval !== 'lifetime') {
            $subscription->ends_at = $plan->interval === 'monthly'
                ? now()->addMonth()
                : now()->addYear();
        }

        $this->subscriptions()->save($subscription);

        // تفعيل الموارد
        $subscription->activateAdminResources();

        event(new \App\Events\SubscriptionCreated($subscription));

        return $subscription;
    }

    /**
     * إلغاء الاشتراك
     */
    public function cancelSubscription(): ?Subscription
    {
        $subscription = $this->subscription();

        if ($subscription) {
            $subscription->update([
                'canceled_at' => now(),
                'status' => 'canceled',
            ]);

            event(new \App\Events\SubscriptionCanceled($subscription));
        }

        return $subscription;
    }

    /**
     * التحقق من إمكانية الوصول للوحة التحكم
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // السماح بالدخول فقط إذا كان لديه اشتراك نشط
        return $this->subscribed();
    }

    /**
     * علاقة Many-to-Many مع الأقسام (Branches)
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'admin_branch')
            ->withTimestamps();
    }

    /**
     * الحصول على الفروع النشطة فقط
     */
    public function activeBranches(): BelongsToMany
    {
        return $this->branches()->where('branches.is_active', true);
    }

    /**
     * الحصول على المقيمين عبر الفروع
     */
    public function residents()
    {
        return Resident::whereIn('branch_id',
            $this->branches()->pluck('branches.id')
        );
    }

    /**
     * الحصول على المقيمين النشطين فقط
     */
    public function activeResidents()
    {
        return $this->residents()->where('is_active', true);
    }

    /**
     * للبحث بالبريد الإلكتروني في Passport
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }

    /**
     * للتحقق من الصلاحيات
     */
    public function hasAccessToBranch($branchId): bool
    {
        return $this->branches()
            ->where('branch_id', $branchId)
            ->where('branches.is_active', true)
            ->exists();
    }

    /**
     * التحقق من إمكانية إضافة فرع جديد
     */
    public function canAddBranch(): bool
    {
        $subscription = $this->subscription();

        if (!$subscription) {
            return false;
        }

        return $subscription->canUseFeature('branches', 1);
    }

    /**
     * التحقق من إمكانية إضافة مقيم جديد
     */
    public function canAddResident(): bool
    {
        $subscription = $this->subscription();

        if (!$subscription) {
            return false;
        }

        return $subscription->canUseFeature('residents', 1);
    }
}
