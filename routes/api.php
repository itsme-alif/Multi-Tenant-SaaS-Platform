<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;


Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/cancel-subscription', [SubscriptionController::class, 'cancel']);
    Route::get('/subscription-status', [SubscriptionController::class, 'status']);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin-dashboard', function () {
            return response()->json(['message' => 'Admin Dashboard']);
        });
    });

    Route::middleware(['role:tenant_owner'])->group(function () {
        Route::get('/tenant-dashboard', function () {
            return response()->json(['message' => 'Tenant Owner Dashboard']);
        });
    });

    Route::middleware(['role:tenant_user'])->group(function () {
        Route::get('/reports', function () {
            return response()->json(['message' => 'Tenant User Reports']);
        });
    });
});

