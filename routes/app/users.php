<?php

use App\Http\Controllers\App\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('app.dashboard.customers');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('app.dashboard.customers.update');
    
    Route::post('{user}/mobile/enable', [UserController::class, 'enableMobileAccess'])
         ->name('app.dashboard.customers.mobile.enable');
    
    Route::post('{user}/mobile/regenerate-pin', [UserController::class, 'regenerateMobilePin'])
         ->name('app.dashboard.customers.mobile.regenerate-pin');
    
    Route::get('{user}/mobile/info', [UserController::class, 'getMobileInfo'])
         ->name('app.dashboard.customers.mobile.info');
});