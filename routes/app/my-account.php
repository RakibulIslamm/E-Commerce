<?php

use App\Http\Controllers\App\MyAccountController;
use App\Http\Controllers\App\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('account')->group(function () {
    Route::get('/summary', [MyAccountController::class, 'index'])->name('app.summary');
    Route::get('/my-data', [MyAccountController::class, 'account'])->name('app.account.my-data');
    Route::put('/my-data', [MyAccountController::class, 'update_account_info'])->name('app.account.my-data.update');
    Route::get('/orders', [MyAccountController::class, 'my_orders'])->name('app.account.orders');
    Route::get('/orders/show/{order}', [OrderController::class, 'show'])->name('app.account.orders.show');
    Route::get('/change-password', [MyAccountController::class, 'change_password'])->name('app.account.change-password');
});