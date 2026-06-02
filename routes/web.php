<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    
    Route::get('users', [DashboardController::class, 'users']);
    Route::get('users/{user}', [DashboardController::class, 'showUser']);
    
    Route::get('rides', [DashboardController::class, 'rides']);
    Route::get('rides/{ride}', [DashboardController::class, 'showRide']);
    
    Route::get('deliveries', [DashboardController::class, 'deliveries']);
    Route::get('deliveries/{delivery}', [DashboardController::class, 'showDelivery']);
});
