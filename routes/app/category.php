<?php
use App\Http\Controllers\App\CategoryController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('products')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('app.categories');
    ;
    Route::get('categories/{id}', [CategoryController::class, 'edit'])->name('app.categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('app.categories.update');
});