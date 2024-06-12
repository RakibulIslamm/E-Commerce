<?php

use App\Http\Controllers\App\ContentSliderController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('slider')->group(function () {
    Route::get('', [ContentSliderController::class, 'index'])->name('app.slider');
    Route::get('/create', [ContentSliderController::class, 'create'])->name('app.slider.create');
    Route::post('/create', [ContentSliderController::class, 'store'])->name('app.slider.store');
    Route::get('/update/{slider}', [ContentSliderController::class, 'edit'])->name('app.slider.edit');
    Route::put('/update/{slider}', [ContentSliderController::class, 'update'])->name('app.slider.update');
});