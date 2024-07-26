<?php
use App\Http\Controllers\App\CartController;
use App\Http\Controllers\App\OrderController;


Route::post('/get-cart', [CartController::class, 'get_cart']);
Route::get('/cart', [CartController::class, 'index'])->name('app.cart');
Route::post('/cart/add', [CartController::class, 'storeNew'])->name('app.cart.add');
Route::get('/cart/checkout', [OrderController::class, 'create'])->name('app.checkout');
Route::post('/cart/checkout', [OrderController::class, 'store'])->name('app.place-order');
Route::delete('/cart/{product_id}', [CartController::class, 'destroy'])->name('app.cart.remove');