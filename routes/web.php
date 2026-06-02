<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Middleware to set locale
Route::prefix('admin')->middleware([\Illuminate\Session\Middleware\StartSession::class, \App\Http\Middleware\SetAdminLocale::class])->group(function () {
    // Language and Theme Toggle
    Route::get('locale/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'ar'])) {
            session(['locale' => $lang]);
        }
        return back();
    });

    Route::get('theme/{theme}', function ($theme) {
        if (in_array($theme, ['light', 'dark'])) {
            session(['theme' => $theme]);
        }
        return back();
    });

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::post('export', [DashboardController::class, 'export']);
    
    // Users
    Route::get('users', [DashboardController::class, 'users']);
    Route::get('users/{user}', [DashboardController::class, 'showUser']);
    Route::patch('users/{user}/suspend', [DashboardController::class, 'suspendUser']);
    
    // Rides
    Route::get('rides', [DashboardController::class, 'rides']);
    Route::get('rides/{ride}', [DashboardController::class, 'showRide']);
    Route::patch('rides/{ride}/cancel', [DashboardController::class, 'cancelRide']);
    
    // Deliveries
    Route::get('deliveries', [DashboardController::class, 'deliveries']);
    Route::get('deliveries/{delivery}', [DashboardController::class, 'showDelivery']);
    Route::patch('deliveries/{delivery}/cancel', [DashboardController::class, 'cancelDelivery']);
    
    // Profile & Settings
    Route::get('profile', [DashboardController::class, 'profile']);
    Route::post('profile', [DashboardController::class, 'updateProfile']);
    Route::get('settings', [DashboardController::class, 'settings']);
    Route::post('settings', [DashboardController::class, 'updateSettings']);
    Route::get('logout', [DashboardController::class, 'logout']);
});
