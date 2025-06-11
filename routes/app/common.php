<?php
use App\Http\Controllers\App\CorporateContent\CompanyProfileController;
use App\Http\Controllers\App\CorporateContent\ConditionForSaleController;
use App\Http\Controllers\App\ShowNewsController;
use App\Http\Controllers\App\ShowProductController;
use Illuminate\Support\Facades\Route;

Route::prefix("products")->group(function () {
    Route::get('', [ShowProductController::class, 'index'])->name('app.products');
    Route::get('/details/{product}', [ShowProductController::class, 'show'])->name('app.products.show');
});

Route::prefix("news")->group(function () {
    Route::get('', [ShowNewsController::class, 'index'])->name('app.news');
    Route::get('/show/{news}', [ShowNewsController::class, 'show'])->name('app.news.show');
});

Route::prefix("agency")->group(function () {
    Route::get('', [CompanyProfileController::class, 'show_profile'])->name('app.profile');
});

Route::get('condition-for-sale', [ConditionForSaleController::class, 'show'])->name('app.terms.condition-for-sale');