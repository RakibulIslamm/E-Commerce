<?php

use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\Options\DiscountController;
use App\Http\Controllers\App\Options\LimitByLocationController;
use App\Http\Controllers\App\Options\PromotionController;
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
});