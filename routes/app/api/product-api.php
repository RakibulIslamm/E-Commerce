<?php

use App\Http\Controllers\App\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/aggiorna_articolo', [ProductController::class, 'products_api']);
Route::POST('/aggiorna_articolo', [ProductController::class, 'store_api']);
Route::put('/aggiorna_articolo/{id}', [ProductController::class, 'update_api']);
Route::post('/articolo_esistente', [ProductController::class, 'articolo_esistente']);

