<?php
use App\Http\Controllers\App\Dashboard\NewsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('news')->group(function () {
    Route::get('', [NewsController::class, 'index'])->name('app.dashboard.news');
    Route::get('/create', [NewsController::class, 'create'])->name('app.dashboard.news.create');
    Route::post('/create', [NewsController::class, 'store'])->name('app.dashboard.news.store');
    Route::get('/edit/{news}', [NewsController::class, 'edit'])->name('app.dashboard.news.edit');
    Route::put('/edit/{news}', [NewsController::class, 'update'])->name('app.dashboard.news.update');
});