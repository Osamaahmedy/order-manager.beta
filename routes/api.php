<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\ResidentAuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\SubscriptionRenewalController;
use Illuminate\Support\Facades\Route;

// ==================== Admin API Routes ====================
        Route::get('available-delivery-apps', [OrderController::class, 'availableDeliveryApps']);

Route::prefix('admin')->group(function () {
    // Login (Public)
    Route::post('login', [AdminAuthController::class, 'login']);

    // Protected Routes
    Route::middleware('auth:admin-api')->group(function () {
        // Authentication
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('logout-all', [AdminAuthController::class, 'logoutAll']);
        Route::get('profile', [AdminAuthController::class, 'profile']);
      //  Route::put('profile', [AdminAuthController::class, 'updateProfile']);
        Route::get('branches', [AdminAuthController::class, 'branches']);

        // Orders Management
        Route::get('orders', [AdminOrderController::class, 'index']);
        Route::post('orders', [AdminOrderController::class, 'store']);
        Route::get('orders/search', [AdminOrderController::class, 'search']);
        Route::get('orders/statistics', [AdminOrderController::class, 'statistics']);
        //Route::get('orders/branch/{branchId}', [AdminOrderController::class, 'byBranch']);
        //Route::get('orders/resident/{residentId}', [AdminOrderController::class, 'byResident']);
        Route::get('orders/{id}', [AdminOrderController::class, 'show']);

        // Available Resources
        Route::get('available-residents', [AdminOrderController::class, 'availableResidents']);

        // Subscription Renewals
        Route::get('subscription-renewals', [SubscriptionRenewalController::class, 'index']);
        Route::post('subscription-renewals', [SubscriptionRenewalController::class, 'store']);
    });
});

// ==================== Resident API Routes ====================
Route::prefix('resident')->group(function () {
    // Login (Public)
    Route::post('login', [ResidentAuthController::class, 'login']);

    // Protected Routes
    Route::middleware('auth:resident-api')->group(function () {
        // Authentication
        Route::post('logout', [ResidentAuthController::class, 'logout']);
        Route::get('profile', [ResidentAuthController::class, 'profile']);
        Route::get('branch', [ResidentAuthController::class, 'branch']);

        // Orders Management
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/statistics', [OrderController::class, 'statistics']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        //Route::delete('orders/{id}', [OrderController::class, 'destroy']);

       });
});
