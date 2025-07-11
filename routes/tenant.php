<?php

declare(strict_types=1);

use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\ContactController;
use App\Http\Controllers\App\IndexController;
use App\Http\Controllers\App\ProfileController;
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
    Route::get('/contact', [ContactController::class, 'index'])->name('app.contact');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('app.contact.send');


    Route::middleware(['registration_process', 'track_user'])->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('app.home');
        Route::middleware(['auth'])->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('app.profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('app.profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('app.profile.destroy');
        });
        require __DIR__ . '/app/dashboard.php';
        require __DIR__ . '/app/common.php';
        require __DIR__ . '/app/cart.php';
        require __DIR__ . '/app/order.php';
        require __DIR__ . '/app/my-account.php';
    });
    require __DIR__ . '/app/auth.php';
    require __DIR__ . '/app/api/api.php';
});

Route::fallback(function () {
    abort(404);
});
