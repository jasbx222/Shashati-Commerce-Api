<?php

use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\OrderPreparers\OrderPreparerAuthController;
use App\Http\Controllers\Api\OrderPreparers\OrderPreparerController;
use App\Notifications\OrderPrepare\NewOrderNotification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Order Preparers Routes
|--------------------------------------------------------------------------
|
| Routes for managing order preparers and their authentication.
|
*/

// Authentication route for order preparers
Route::post('/login', [OrderPreparerAuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {

 
Route::post('/logout',[ OrderPreparerAuthController::class,'logout']);

    // Routes أخرى باستخدام apiResource لكن بدون index
    Route::apiResource('/orders', OrderPreparerController::class)
    
        ->names([
            'store' => 'orders.store',
            'store' => 'orders.index',
            'show' => 'order.show',
            'update' => 'order.update',
            'destroy' => 'order.destroy',
        ]);

    // Update order status
    Route::post('orders/{order}/status', [OrderPreparerController::class, 'updateStatus']);

// Notification
        Route::prefix('notification')->group(function() {
            Route::get('', [NewOrderNotification::class, 'index']);
     
        });
});

