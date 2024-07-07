<?php
use App\Http\Controllers\App\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('app.dashboard.categories');
    ;
    Route::get('categories/create', [CategoryController::class, 'create'])->name('app.dashboard.categories.create');
    Route::post('categories/create', [CategoryController::class, 'store'])->name('app.dashboard.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('app.dashboard.categories.update');
    Route::delete('/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('app.dashboard.categories.delete');
});