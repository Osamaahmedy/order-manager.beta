<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\SubscriptionUsage;

Schedule::command('subscriptions:expire')->daily();

Schedule::call(function () {
    SubscriptionUsage::whereDate('reset_at', '<', now())->delete();
})->daily();
