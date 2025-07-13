<?php

use App\Http\Controllers\App\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function () {
    // Route esistenti
    Route::get('', [UserController::class, 'index'])->name('app.dashboard.customers');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('app.dashboard.customers.update');
    
    // Nuove route per gestione mobile - AGGIUNGI QUESTE
    Route::post('{user}/mobile/enable', [UserController::class, 'enableMobileAccess'])
         ->name('app.dashboard.customers.mobile.enable');
    
    Route::post('{user}/mobile/disable', [UserController::class, 'disableMobileAccess'])
         ->name('app.dashboard.customers.mobile.disable');
    
    Route::post('{user}/mobile/regenerate-pin', [UserController::class, 'regenerateMobilePin'])
         ->name('app.dashboard.customers.mobile.regenerate-pin');
    
    Route::get('{user}/mobile/info', [UserController::class, 'getMobileInfo'])
         ->name('app.dashboard.customers.mobile.info');
    
    Route::put('{user}/mobile/settings', [UserController::class, 'updateMobileSettings'])
         ->name('app.dashboard.customers.mobile.settings');
    
    // Lista utenti con accesso mobile
    Route::get('mobile-users', [UserController::class, 'getMobileUsers'])
         ->name('app.dashboard.customers.mobile.list');
});