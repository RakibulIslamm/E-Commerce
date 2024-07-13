<?php
use App\Http\Controllers\App\CartController;


Route::post('/get-cart', [CartController::class, 'get_cart']);
Route::get('/cart', [CartController::class, 'index'])->name('app.cart');
Route::post('/cart/add', [CartController::class, 'store'])->name('app.cart.add');

Route::middleware('auth')->group(function () {
    Route::post('/set-cart', [CartController::class, 'setCartToTable']);
    Route::delete('/cart/{product_id}', [CartController::class, 'destroy'])->name('app.cart.remove');
});