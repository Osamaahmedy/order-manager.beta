<?php
// app/Observers/SubscriptionObserver.php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function retrieved(Subscription $subscription)
    {
        // ✅ التحقق من انتهاء الفترة التجريبية
        if ($subscription->status === 'active' &&
            $subscription->trial_ends_at &&
            $subscription->trial_ends_at->isPast() &&
            !$subscription->ends_at) { // لم يتم الترقية

            $subscription->update(['status' => 'expired']);
            return;
        }

        // ✅ التحقق من انتهاء الاشتراك العادي
        if ($subscription->status === 'active' &&
            $subscription->ends_at &&
            $subscription->ends_at->isPast() &&
            !$subscription->onTrial()) { // الفترة التجريبية انتهت أيضاً

            $subscription->update(['status' => 'expired']);
        }
    }
}
