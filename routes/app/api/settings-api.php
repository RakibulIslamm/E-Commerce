<?php

use App\Http\Controllers\App\SettingsApiController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingsApiController::class, 'index']);
Route::put('/settings/update', [SettingsApiController::class, 'update']);
