<?php

use App\Http\Controllers\App\Options\DiscountController;
use App\Http\Controllers\App\Options\PromotionController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('options')->group(function () {

    Route::prefix('promotions')->group(function () {
        Route::get('', [PromotionController::class, 'index'])->name('app.promotions');

        Route::get('/create', [PromotionController::class, 'create'])->name('app.promotions.create');

        Route::post('/create', [PromotionController::class, 'store'])->name('app.promotions.store');

        Route::get('/edit/{promotion}', [PromotionController::class, 'edit'])->name('app.promotions.edit');

        Route::put('/edit/{promotion}', [PromotionController::class, 'update'])->name('app.promotions.update');
    });

    Route::prefix('discounts')->group(function () {
        Route::get('', [DiscountController::class, 'index'])->name('app.discounts');
        Route::get('/create', [DiscountController::class, 'create'])->name('app.discounts.create');
        Route::get('/edit/{promotion}', [DiscountController::class, 'edit'])->name('app.discounts.edit');
    });
});