<?php
use App\Http\Controllers\App\MyAccountController;

Route::middleware(['auth'])->prefix('account')->group(function () {
    Route::get('', [MyAccountController::class, 'index'])->name('app.account');
    Route::get('/billing', [MyAccountController::class, 'billing'])->name('app.account.billing');
    Route::get('/orders', [MyAccountController::class, 'my_orders'])->name('app.account.orders');
    Route::get('/change-password', [MyAccountController::class, 'change_password'])->name('app.account.change-password');
});