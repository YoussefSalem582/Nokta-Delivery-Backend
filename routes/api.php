<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;

// Prefix /api is already implied by the api.php routing file.
// We group under v1
Route::prefix('v1')->group(function () {
    
    // Public Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        // Password reset routes (stubs for now, will implement logic in subsequent phase if needed)
        // Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        // Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

    // Protected Auth Routes
    Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('device-token', [AuthController::class, 'deviceToken']);
    });

    // Driver Routes (Simulated endpoints for Flutter map and dispatch)
    Route::middleware(['auth:sanctum', 'role:DRIVER'])->prefix('driver')->group(function () {
        Route::get('offers', [\App\Http\Controllers\Api\V1\DriverController::class, 'offers']);
        Route::post('offers/{id}/accept', [\App\Http\Controllers\Api\V1\DriverController::class, 'acceptOffer']);
        Route::post('offers/{id}/decline', [\App\Http\Controllers\Api\V1\DriverController::class, 'declineOffer']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('profile', [ProfileController::class, 'show']);

    // Drivers
    Route::get('drivers', [\App\Http\Controllers\Api\V1\DriverController::class, 'index']);

    // Rides (Trips)
    Route::prefix('trips')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\TripController::class, 'index']);
        Route::get('active', [\App\Http\Controllers\Api\V1\TripController::class, 'active']);
        Route::post('request', [\App\Http\Controllers\Api\V1\TripController::class, 'requestRide']);
        Route::get('{id}', [\App\Http\Controllers\Api\V1\TripController::class, 'show']);
        Route::patch('{id}/status', [\App\Http\Controllers\Api\V1\TripController::class, 'updateStatus']);
    });

    // Alias for rides to match Flutter endpoint sometimes expected as 'rides/estimate-fare'
    Route::post('rides/estimate-fare', [\App\Http\Controllers\Api\V1\TripController::class, 'estimateFare']);
});
