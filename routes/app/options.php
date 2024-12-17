<?php

use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\Options\DiscountController;
use App\Http\Controllers\App\Options\LimitByLocationController;
use App\Http\Controllers\App\Options\PromotionController;
use App\Http\Controllers\App\Options\ShippingController;
use Illuminate\Support\Facades\Route;

Route::prefix('options')->group(function () {

    Route::prefix('promotions')->group(function () {
        Route::get('', [PromotionController::class, 'index'])->name('app.promotions');

        Route::get('/create', [PromotionController::class, 'create'])->name('app.promotions.create');

        Route::post('/create', [PromotionController::class, 'store'])->name('app.promotions.store');

        Route::get('/edit/{promotion}', [PromotionController::class, 'edit'])->name('app.promotions.edit');

        Route::put('/edit/{promotion}', [PromotionController::class, 'update'])->name('app.promotions.update');

    });

    Route::get('/change-password', [PasswordController::class, 'edit'])->name('app.change-password');

    Route::prefix('discounts')->group(function () {
        Route::get('', [DiscountController::class, 'index'])->name('app.discounts');
        Route::get('/create', [DiscountController::class, 'create'])->name('app.discounts.create');
        Route::get('/edit/{promotion}', [DiscountController::class, 'edit'])->name('app.discounts.edit');
    });

    Route::prefix('cap')->group(function () {
        Route::get('', [LimitByLocationController::class, 'index'])->name('app.cap');
        Route::delete('/delete/{availableLocation}', [LimitByLocationController::class, 'destroy'])->name('app.cap.delete');
    });

    Route::prefix('shipping-settings')->group(function () {
        Route::get('/', [ShippingController::class, 'index'])->name('app.shipping-settings');
        // Route::get('/show/{shippingSetting}', [ShippingController::class, 'show'])->name('app.shipping-settings.show');
        Route::get('/create', [ShippingController::class, 'create'])->name('app.shipping-settings.create');

        Route::post('/create', [ShippingController::class, 'store'])->name('app.shipping-settings.store');

        Route::get('/edit/{shippingSetting}', [ShippingController::class, 'edit'])->name('app.shipping-settings.edit');

        Route::put('/edit/{shippingSetting}', [ShippingController::class, 'update'])->name('app.shipping-settings.update');

        Route::delete('/delete/{shippingSetting}', [ShippingController::class, 'destroy'])->name('app.shipping-settings.delete');
    });
});