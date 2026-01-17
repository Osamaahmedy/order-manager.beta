<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\ResidentAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminOrderController;

// ==================== Admin API Routes ====================
Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin-api')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::get('profile', [AdminAuthController::class, 'profile']);
        Route::get('branches', [AdminAuthController::class, 'branches']);
        Route::get('orders', [AdminOrderController::class, 'index']);
        Route::get('orders/statistics', [AdminOrderController::class, 'statistics']);
        Route::get('orders/search', [AdminOrderController::class, 'search']);
        Route::get('orders/{id}', [AdminOrderController::class, 'show']);
        Route::get('orders/branch/{branchId}', [AdminOrderController::class, 'byBranch']);
        Route::get('orders/resident/{residentId}', [AdminOrderController::class, 'byResident']);
    });
});

// ==================== Resident API Routes ====================
Route::prefix('resident')->group(function () {
    Route::post('login', [ResidentAuthController::class, 'login']);

    Route::middleware('auth:resident-api')->group(function () {
        Route::post('logout', [ResidentAuthController::class, 'logout']);
        Route::get('profile', [ResidentAuthController::class, 'profile']);
        Route::get('branch', [ResidentAuthController::class, 'branch']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::delete('orders/{id}', [OrderController::class, 'destroy']);
        Route::get('orders/statistics', [OrderController::class, 'statistics']);

    });
});
