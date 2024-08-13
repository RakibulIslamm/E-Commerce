<?php
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {

    Route::get('', function () {
        return "Welcome to AsterSoftware REST Server";
    });

    require __DIR__ . '/product-api.php';
    require __DIR__ . '/settings-api.php';
    require __DIR__ . '/order-api.php';
    require __DIR__ . '/category-api.php';
    require __DIR__ . '/common-api.php';
});
