<?php

use App\Http\Controllers\App\Dashboard\ContentSliderController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::prefix('slider')->group(function () {
    Route::get('', [ContentSliderController::class, 'index'])->name('app.dashboard.slider');
    Route::get('/create', [ContentSliderController::class, 'create'])->name('app.dashboard.slider.create');
    Route::post('/create', [ContentSliderController::class, 'store'])->name('app.dashboard.slider.store');
    Route::get('/update/{slider}', [ContentSliderController::class, 'edit'])->name('app.dashboard.slider.edit');
    Route::put('/update/{slider}', [ContentSliderController::class, 'update'])->name('app.dashboard.slider.update');
});