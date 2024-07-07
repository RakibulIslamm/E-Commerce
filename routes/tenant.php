<?php

declare(strict_types=1);

use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\ContactController;
use App\Http\Controllers\App\IndexController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\DashboardController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::get('/contact', [ContactController::class, 'index'])->name('app.contact');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('app.dashboard')->middleware(['auth']);

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('app.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('app.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('app.profile.destroy');

        Route::prefix('options')->group(function () {
            Route::get('/change-password', [PasswordController::class, 'edit'])->name('app.change-password');
        });

        // dd('inside');
    });
    require __DIR__ . '/app/dashboard.php';
});

require __DIR__ . '/app/ecommerce-api/settings-api.php';
require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/corporate-content.php';
require __DIR__ . '/app/slider.php';
require __DIR__ . '/app/category.php';
require __DIR__ . '/app/options.php';
