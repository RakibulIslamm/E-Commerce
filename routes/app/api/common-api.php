<?php
use App\Http\Controllers\App\Options\LimitByLocationController;
use App\Http\Controllers\App\RestAPI\CommonAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/locations', [LimitByLocationController::class, 'get_locations']);
Route::post('/add-cap', [LimitByLocationController::class, 'store']);

Route::get('/location/{zip_code}', [CommonAPIController::class, 'get_location']);