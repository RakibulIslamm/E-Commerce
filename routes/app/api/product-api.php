<?php

use App\Http\Controllers\App\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/products', [ProductController::class, 'products_api']);
Route::get('/products/create', [ProductController::class, 'store_api']);
Route::put('/products/update', [ProductController::class, 'update_api']);
