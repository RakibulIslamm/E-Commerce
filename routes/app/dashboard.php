<?php
use App\Http\Controllers\App\Dashboard\DashboardController;


Route::middleware(['auth'])->prefix('dashboard')->group(function () {


    Route::get('', [DashboardController::class, 'index'])->name('app.dashboard');

    require __DIR__ . '/news.php';
    require __DIR__ . '/product.php';
    require __DIR__ . '/category.php';
    require __DIR__ . '/slider.php';
});



