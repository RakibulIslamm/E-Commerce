<?php
use App\Http\Controllers\App\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index'])->name('app.dashboard.products');
    Route::get('/create', [ProductController::class, 'create'])->name('app.dashboard.product.create');
    Route::post('/create', [ProductController::class, 'store'])->name('app.dashboard.product.store');
    Route::get('/update/{product}', [ProductController::class, 'edit'])->name('app.dashboard.product.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('app.dashboard.product.update');
    Route::put('/upload/{product}', [ProductController::class, 'uploadProductImages'])->name('app.dashboard.product.upload');
    Route::post('/delete-product-image/{id}', [ProductController::class, 'deleteProductImage'])->name('app.dashboard.product.delete-product-image');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('app.dashboard.product.delete');
});