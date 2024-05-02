<?php

use App\Http\Controllers\EcommerceRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/request-an-ecommerce', [EcommerceRequestController::class, 'create'])->name('request.create');

    Route::post('/request-an-ecommerce', [EcommerceRequestController::class, 'store'])->name('request.store');
});
