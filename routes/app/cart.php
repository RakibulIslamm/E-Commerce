<?php
use App\Http\Controllers\App\CartController;
use App\Http\Controllers\App\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/get-cart', [CartController::class, 'get_cart']);
Route::get('/cart', [CartController::class, 'index'])->name('app.cart');
Route::post('/cart/add', [CartController::class, 'storeNew'])->name('app.cart.add');
Route::get('/cart/checkout', [OrderController::class, 'create'])->name('app.checkout');
Route::post('/cart/checkout/place-order', [OrderController::class, 'store'])->name('app.place-order');
Route::get('/cart/checkout/confirm', [OrderController::class, 'confirm_order'])->name('app.confirm-order');
Route::delete('/cart/{product_id}', [CartController::class, 'destroy'])->name('app.cart.remove');