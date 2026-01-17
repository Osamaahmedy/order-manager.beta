<?php
// app/Console/Commands/ExpireSubscriptions.php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';

    protected $description = 'إنهاء الاشتراكات المنتهية وتعطيل الموارد';

    public function handle()
    {
        $count = 0;

        // ✅ إنهاء الاشتراكات التجريبية المنتهية
        $expiredTrials = Subscription::where('status', 'active')
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '<', now())
            ->whereNull('ends_at') // لم يتم الترقية بعد
            ->get();

        foreach ($expiredTrials as $subscription) {
            $subscription->update(['status' => 'expired']);
            $this->warn("تم إنهاء الفترة التجريبية لـ Admin #{$subscription->admin_id}");
            $count++;
        }

        // ✅ إنهاء الاشتراكات العادية المنتهية
        $expired = Subscription::where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<', now())
            ->get();

        foreach ($expired as $subscription) {
            // التحقق من أن الفترة التجريبية أيضاً انتهت
            if (!$subscription->onTrial()) {
                $subscription->update(['status' => 'expired']);
                $this->info("تم إنهاء اشتراك Admin #{$subscription->admin_id}");
                $count++;
            }
        }

        // ✅ تنبيهات للاشتراكات القريبة من الانتهاء (7 أيام)
        $expiringSoon = Subscription::where('status', 'active')
            ->where(function ($query) {
                // الفترة التجريبية قريبة من الانتهاء
                $query->whereBetween('trial_ends_at', [now(), now()->addDays(7)])
                      // أو الاشتراك العادي قريب من الانتهاء
                      ->orWhereBetween('ends_at', [now(), now()->addDays(7)]);
            })
            ->get();

        foreach ($expiringSoon as $subscription) {
            $type = $subscription->onTrial() ? 'التجريبية' : 'الاشتراك';
            event(new \App\Events\SubscriptionExpiringSoon($subscription));
            $this->warn("تنبيه: الفترة {$type} لـ Admin #{$subscription->admin_id} ستنتهي قريباً");
        }

        $this->info("تم معالجة {$count} اشتراك منتهي");
        return 0;
    }
}
