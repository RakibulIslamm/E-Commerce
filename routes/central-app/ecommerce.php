<?php

use App\Http\Controllers\CentralApp\EcommerceController;
use Illuminate\Support\Facades\Route;

// * Ecommerce Routes

Route::middleware(['auth'])->prefix('ecommerces')->group(function () {
    Route::get('/', [EcommerceController::class, 'index'])->name('ecommerce.index');

    Route::get('/show/{ecommerce}', [EcommerceController::class, 'show']);

    Route::get('/create', [EcommerceController::class, 'create'])->name('ecommerces.create');

    Route::post('/create', [EcommerceController::class, 'store'])->name('ecommerce.store');

    Route::get('/edit/{ecommerce}', [EcommerceController::class, 'edit'])->name('ecommerce.edit');

    Route::put('/update/{ecommerce}', [EcommerceController::class, 'update'])->name('ecommerce.update');

    Route::put('/suspend_tenant/{ecommerce}', [EcommerceController::class, 'suspend'])->name('ecommerce.suspend_tenant');
});



Route::delete('/ecommerces/delete/{ecommerce}', [EcommerceController::class, 'destroy'])->middleware(['auth', 'verified', 'admin'])->name('ecommerce.delete');
