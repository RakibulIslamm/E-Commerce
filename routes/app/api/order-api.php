<?php
use App\Http\Controllers\App\Dashboard\OrderController;

Route::get('/elenco_ordini', [OrderController::class, 'orders_api']);
Route::post('/cambia_stato_ordine', [OrderController::class, 'change_order_status']);
Route::post('/place_order', [OrderController::class, 'place_order']);