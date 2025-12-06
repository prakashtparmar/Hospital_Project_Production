<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['web'])->group(function () {

    // Tenant HOME route
    Route::get('/', [DashboardController::class, 'index'])
        ->name('tenant.dashboard');

    // Tenant Dashboard (optional second alias)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('tenant.dashboard.alt');

});
