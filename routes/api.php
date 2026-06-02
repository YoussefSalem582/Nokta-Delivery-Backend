<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;

// We group under v1
Route::prefix('v1')->group(function () {
    
    // Public Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    });

    // Public Driver Routes
    Route::prefix('driver')->group(function () {
        Route::post('register', [AuthController::class, 'driverRegister']);
    });

    // Protected API v1 Routes
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth protected
        Route::prefix('auth')->group(function () {
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('device-token', [AuthController::class, 'deviceToken']);
        });

        // Driver protected routes
        Route::middleware('role:DRIVER')->prefix('driver')->group(function () {
            Route::get('profile', [ProfileController::class, 'driverProfile']);
            Route::patch('availability', [\App\Http\Controllers\Api\V1\DriverController::class, 'updateAvailability']);
            Route::get('offers', [\App\Http\Controllers\Api\V1\DriverController::class, 'offers']);
            Route::post('offers/{id}/accept', [\App\Http\Controllers\Api\V1\DriverController::class, 'acceptOffer']);
            Route::post('offers/{id}/decline', [\App\Http\Controllers\Api\V1\DriverController::class, 'declineOffer']);
        });

    });
});

// Protected routes that might not be under v1 in NestJS (matching Flutter app expectations)
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('profile', [ProfileController::class, 'show']);

    // Riders
    Route::get('riders', [\App\Http\Controllers\Api\V1\RiderController::class, 'index']);

    // Orders
    Route::get('orders', [\App\Http\Controllers\Api\V1\OrderController::class, 'index']);

    // Drivers
    Route::get('drivers', [\App\Http\Controllers\Api\V1\DriverController::class, 'index']);
    Route::get('drivers/{id}/reviews', [\App\Http\Controllers\Api\V1\DriverController::class, 'reviews']);

    // Rides (Trips)
    Route::prefix('trips')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\TripController::class, 'index']);
        Route::get('active', [\App\Http\Controllers\Api\V1\TripController::class, 'active']);
        Route::post('request', [\App\Http\Controllers\Api\V1\TripController::class, 'requestRide']);
        Route::get('{id}', [\App\Http\Controllers\Api\V1\TripController::class, 'show']);
        Route::patch('{id}/status', [\App\Http\Controllers\Api\V1\TripController::class, 'updateStatus']);
        Route::post('{id}/location', [\App\Http\Controllers\Api\V1\LocationController::class, 'updateRideLocation'])->middleware('role:DRIVER');
    });

    // Alias for rides to match Flutter endpoint sometimes expected as 'rides/estimate-fare'
    Route::post('rides/estimate-fare', [\App\Http\Controllers\Api\V1\TripController::class, 'estimateFare']);

    // Deliveries
    Route::prefix('deliveries')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'index']);
        Route::get('active', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'active']);
        Route::post('/', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'store']);
        Route::get('{id}', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'show']);
        Route::get('{id}/tracking', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'tracking']);
        Route::patch('{id}/status', [\App\Http\Controllers\Api\V1\DeliveryController::class, 'updateStatus']);
        Route::post('{id}/location', [\App\Http\Controllers\Api\V1\LocationController::class, 'updateDeliveryLocation'])->middleware('role:COURIER');
    });

    // Offline Sync
    Route::prefix('sync')->group(function () {
        Route::post('actions', [\App\Http\Controllers\Api\V1\SyncController::class, 'syncActions']);
        Route::get('reconcile', [\App\Http\Controllers\Api\V1\SyncController::class, 'reconcile']);
    });
});
