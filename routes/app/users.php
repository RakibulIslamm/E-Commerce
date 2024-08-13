<?php

use App\Http\Controllers\App\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('app.dashboard.customers');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('app.dashboard.customers.update');
});