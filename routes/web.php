<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('users', [\App\Http\Controllers\Admin\DashboardController::class, 'users']);
    Route::get('rides', [\App\Http\Controllers\Admin\DashboardController::class, 'rides']);
    Route::get('deliveries', [\App\Http\Controllers\Admin\DashboardController::class, 'deliveries']);
});
