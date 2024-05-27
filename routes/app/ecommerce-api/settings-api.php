<?php

use App\Http\Controllers\App\SettingsController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/api/settings', [SettingsController::class, 'index']);
    Route::put('/settings/update', [SettingsController::class, 'update']);
});
