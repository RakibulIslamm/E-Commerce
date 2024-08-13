<?php

use App\Http\Controllers\CentralApp\DashboardController;
use App\Http\Controllers\CentralApp\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'central_domain'
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('central.login');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/central-app/auth.php';
    require __DIR__ . '/central-app/request.php';
    require __DIR__ . '/central-app/user.php';
    require __DIR__ . '/central-app/ecommerce.php';
});


Route::fallback(function () {
    abort(404);
});