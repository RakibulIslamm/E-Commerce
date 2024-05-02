<?php

use App\Http\Controllers\EcommerceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/ecommerce/requests', [EcommerceRequestController::class, 'index'])->middleware(['auth'])->name('request.index');

Route::get('/ecommerce/requests/{ecommerceRequest}', [EcommerceRequestController::class, 'show'])->middleware(['auth'])->name('request.show');
