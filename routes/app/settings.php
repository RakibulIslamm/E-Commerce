<?php

use App\Http\Controllers\App\EcommerceSettingsController;
use App\Http\Controllers\App\GeneralSettingsController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('settings')->group(function () {

    Route::prefix('general')->group(function () {
        Route::get('', [GeneralSettingsController::class, 'index'])->name('app.settings.general');
    });

    Route::prefix('ecommerce')->group(function () {
        Route::get('', [EcommerceSettingsController::class, 'index'])->name('app.settings.ecommerce');

        Route::get('/update', [EcommerceSettingsController::class, 'edit'])->name('app.settings.ecommerce.edit');

        Route::put('/update', [EcommerceSettingsController::class, 'update'])->name('app.settings.ecommerce.update');
    });

    Route::get('/account', [EcommerceSettingsController::class, 'index'])->name('app.settings.account');
});