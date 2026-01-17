// routes/console.php
<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\SubscriptionUsage;

// تشغيل أمر انتهاء الاشتراكات يومياً
Schedule::command('subscriptions:expire')->daily();

// إعادة تعيين حدود الاستخدام الشهرية
Schedule::call(function () {
    SubscriptionUsage::whereDate('reset_at', '<', now())->delete();
})->daily();
