<?php
use App\Http\Controllers\App\Dashboard\DashboardController;
use App\Http\Controllers\App\Dashboard\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {


    Route::get('', [DashboardController::class, 'index'])->name('app.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('app.dashboard.orders');

    require __DIR__ . '/news.php';
    require __DIR__ . '/product.php';
    require __DIR__ . '/category.php';
    require __DIR__ . '/slider.php';
    require __DIR__ . '/corporate-content.php';
    require __DIR__ . '/options.php';
    require __DIR__ . '/users.php';
});



