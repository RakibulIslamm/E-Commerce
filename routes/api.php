

<?php

use App\Http\Controllers\EcommerceController;
use Illuminate\Support\Facades\Route;

Route::get('/api/ecommerce/{id}', [EcommerceController::class, 'getSingleEcommerce']);
Route::get('/api/ecommerces', [EcommerceController::class, 'index']);
// Route::get('/ecommerce/{id}', 'EcommerceController@getSingleEcommerce');