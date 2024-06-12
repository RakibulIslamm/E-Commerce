<?php

use App\Http\Controllers\App\EcommerceSettingsController;
use App\Http\Controllers\App\CorporateDataController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('corporate-content')->group(function () {

    Route::prefix('corporate-data')->group(function () {
        Route::get('', [CorporateDataController::class, 'index'])->name('app.corporate-data');
        Route::put('/brand', [CorporateDataController::class, 'update_brand'])->name('app.corporate-data.update-brand');

        Route::put('/corporate-data', [CorporateDataController::class, 'update_address'])->name('app.corporate-data.update-corporate-data');

        Route::put('/social', [CorporateDataController::class, 'update_social'])->name('app.corporate-data.update-social');
    });

    Route::prefix('ecommerce')->group(function () {
        Route::get('', [EcommerceSettingsController::class, 'index'])->name('app.corporate-content.ecommerce');

        Route::get('/update', [EcommerceSettingsController::class, 'edit'])->name('app.corporate-content.ecommerce.edit');

        Route::put('/update', [EcommerceSettingsController::class, 'update'])->name('app.corporate-content.ecommerce.update');
    });

    Route::get('/account', [EcommerceSettingsController::class, 'index'])->name('app.corporate-content.account');
});