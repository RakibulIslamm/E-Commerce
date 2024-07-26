<?php
use App\Http\Controllers\App\RestAPI\CommonAPIController;


Route::get('/location/{zip_code}', [CommonAPIController::class, 'get_location']);