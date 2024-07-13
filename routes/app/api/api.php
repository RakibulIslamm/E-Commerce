<?php
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::prefix('api')->group(function () {

    Route::get('', function () {
        return "Welcome to AsterSoftware REST Server";
    });

    require __DIR__ . '/product-api.php';
    require __DIR__ . '/settings-api.php';
    require __DIR__ . '/order-api.php';
    require __DIR__ . '/category-api.php';
});
