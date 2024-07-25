<?php

use App\Http\Controllers\CentralApp\EcommerceRequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/ecommerce/requests', [EcommerceRequestController::class, 'index'])->name('request.index');

    Route::get('/ecommerce/requests/{ecommerceRequest}', [EcommerceRequestController::class, 'show'])->name('request.show');

    Route::get('/request-an-ecommerce', [EcommerceRequestController::class, 'create'])->name('request.create');

    Route::post('/request-an-ecommerce', [EcommerceRequestController::class, 'store'])->name('request.store');
});


