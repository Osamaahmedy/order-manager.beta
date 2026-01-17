<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Subscription;  // ✅ موجود
use App\Observers\SubscriptionObserver;  // ✅ موجود
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Policies\OrderPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // نقل الـ Observer من register إلى boot
        Subscription::observe(SubscriptionObserver::class);

        Passport::enablePasswordGrant();
    }
}
