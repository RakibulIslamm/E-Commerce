<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('api')->group(function () {

    Route::middleware('auth.basic')->group(function(){
        Route::get('', function (Request $request) {
            return response()->json([
                'msg' => 'Welcome to AsterSoftware REST Server vers. 1.0'
            ]);
        });
        require __DIR__ . '/product-api.php';
        require __DIR__ . '/order-api.php';
        require __DIR__ . '/category-api.php';
    });
    require __DIR__ . '/settings-api.php';
    require __DIR__ . '/common-api.php';
});
