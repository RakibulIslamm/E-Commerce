<?php

use App\Http\Controllers\EcommerceController;
use Illuminate\Support\Facades\Route;

// * Ecommerce Routes
Route::get('/ecommerce', [EcommerceController::class, 'index'])->name('ecommerce.index')->middleware(['auth', 'verified']);

Route::get('/ecommerce/show/{ecommerce}', [EcommerceController::class, 'show'])->middleware(['auth', 'verified']);

Route::get('/ecommerce/create', [EcommerceController::class, 'create'])->middleware(['auth', 'verified']);

Route::post('/ecommerce/create', [EcommerceController::class, 'store'])->middleware(['auth', 'verified'])->name('ecommerce.create');

Route::get('/ecommerce/edit/{ecommerce}', [EcommerceController::class, 'edit'])->middleware(['auth'])->name('ecommerce.edit');

Route::put('/ecommerce/update/{ecommerce}', [EcommerceController::class, 'update'])->middleware(['auth'])->name('ecommerce.update');

Route::delete('/ecommerce/delete/{ecommerce}', [EcommerceController::class, 'destroy'])->middleware(['auth', 'verified', 'admin'])->name('ecommerce.delete');
