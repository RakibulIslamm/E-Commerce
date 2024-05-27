<?php

use App\Http\Controllers\CentralApp\EcommerceController;
use Illuminate\Support\Facades\Route;

// * Ecommerce Routes

Route::middleware(['auth', 'verified'])->prefix('ecommerces')->group(function () {
    Route::get('/', [EcommerceController::class, 'index'])->name('ecommerce.index');

    Route::get('/show/{ecommerce}', [EcommerceController::class, 'show']);

    Route::get('/create', [EcommerceController::class, 'create']);

    Route::post('/create', [EcommerceController::class, 'store'])->name('ecommerce.create');

    Route::get('/edit/{ecommerce}', [EcommerceController::class, 'edit'])->name('ecommerce.edit');

    Route::put('/update/{ecommerce}', [EcommerceController::class, 'update'])->name('ecommerce.update');
});



Route::delete('/ecommerces/delete/{ecommerce}', [EcommerceController::class, 'destroy'])->middleware(['auth', 'verified', 'admin'])->name('ecommerce.delete');
