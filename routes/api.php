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

    // We can place the profile route outside v1 if following NestJS exactly (/api/profile),
    // but the task says /api/profile
});

// Profile route (Protected) - NestJS had it at /api/profile
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
});
