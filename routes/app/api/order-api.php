<?php
use App\Http\Controllers\App\Dashboard\OrderController;

Route::post('/elenco_ordini', [OrderController::class, 'get_orders']);
Route::post('/cambia_stato_ordine', [OrderController::class, 'change_order_status']);
Route::post('/place_order', [OrderController::class, 'place_order']);