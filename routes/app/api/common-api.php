<?php
use App\Http\Controllers\App\Options\LimitByLocationController;
use App\Http\Controllers\App\RestAPI\CommonAPIController;


Route::get('/locations', [LimitByLocationController::class, 'get_locations']);

Route::get('/location/{zip_code}', [CommonAPIController::class, 'get_location']);