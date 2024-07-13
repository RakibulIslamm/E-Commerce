<?php
use App\Http\Controllers\App\Dashboard\ProductController;

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index'])->name('app.dashboard.products');
    Route::get('/create', [ProductController::class, 'create'])->name('app.dashboard.product.create');
    Route::post('/create', [ProductController::class, 'store'])->name('app.dashboard.product.store');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('app.dashboard.product.delete');
});