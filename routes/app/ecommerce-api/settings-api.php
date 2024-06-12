<?php

use App\Http\Controllers\App\SettingsApiController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api')->group(function () {
    Route::get('/settings', [SettingsApiController::class, 'index']);
    Route::put('/settings/update', [SettingsApiController::class, 'update']);
});
