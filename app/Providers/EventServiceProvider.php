<?php
// app/Providers/EventServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\SubscriptionCreated;
use App\Events\SubscriptionCanceled;
use App\Events\SubscriptionExpiringSoon;
use App\Listeners\SendSubscriptionWelcomeEmail;
use App\Listeners\SendSubscriptionCanceledEmail;
use App\Listeners\SendSubscriptionExpiringNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SubscriptionCreated::class => [
            SendSubscriptionWelcomeEmail::class,
        ],
        SubscriptionCanceled::class => [
            SendSubscriptionCanceledEmail::class,
        ],
        SubscriptionExpiringSoon::class => [
            SendSubscriptionExpiringNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
