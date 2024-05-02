<?php

use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\EcommerceRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Admin dashboard
/* Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Admin');
    })->name('admin.dashboard');
}); */
