<?php

namespace App\Listeners;

use App\Events\SubscriptionExpiringSoon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubscriptionExpiringNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SubscriptionExpiringSoon $event): void
    {
        //
    }
}
