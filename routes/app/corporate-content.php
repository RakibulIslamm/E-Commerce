<?php

use App\Http\Controllers\App\CorporateContent\CompanyProfileController;
use App\Http\Controllers\App\CorporateContent\ConditionForSaleController;
use App\Http\Controllers\App\CorporateContent\CorporateDataController;
use App\Http\Controllers\App\CorporateContent\EcommerceSettingsController;
use Illuminate\Support\Facades\Route;


Route::prefix('corporate-content')->group(function () {

    Route::prefix('corporate-data')->group(function () {
        Route::get('', [CorporateDataController::class, 'index'])->name('app.corporate-data');
        Route::put('/brand', [CorporateDataController::class, 'update_brand'])->name('app.corporate-data.update-brand');

        Route::put('/corporate-data', [CorporateDataController::class, 'update_address'])->name('app.corporate-data.update-corporate-data');

        Route::put('/smtp', [CorporateDataController::class, 'update_smtp'])->name('app.corporate-data.update-smtp');

        Route::put('/social', [CorporateDataController::class, 'update_social'])->name('app.corporate-data.update-social');
    });

    Route::prefix('ecommerce')->group(function () {
        Route::get('', [EcommerceSettingsController::class, 'index'])->name('app.corporate-content.ecommerce');

        Route::get('/update', [EcommerceSettingsController::class, 'edit'])->name('app.corporate-content.ecommerce.edit');

        Route::put('/update', [EcommerceSettingsController::class, 'update'])->name('app.corporate-content.ecommerce.update');
    });

    Route::prefix('company-profile')->group(function () {
        Route::get('', [CompanyProfileController::class, 'index'])->name('app.corporate-content.company-profile');

        Route::get('/edit', [CompanyProfileController::class, 'edit'])->name('app.corporate-content.company-profile.edit');

        Route::put('/edit', [CompanyProfileController::class, 'update'])->name('app.corporate-content.company-profile.update');
    });

    Route::prefix('condition-for-sale')->group(function () {
        Route::get('', [ConditionForSaleController::class, 'index'])->name('app.corporate-content.condition-for-sale');

        Route::get('/edit', [ConditionForSaleController::class, 'edit'])->name('app.corporate-content.condition-for-sale.edit');

        Route::put('/edit', [ConditionForSaleController::class, 'update'])->name('app.corporate-content.condition-for-sale.update');
    });
});