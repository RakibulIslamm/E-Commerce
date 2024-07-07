<?php
use App\Http\Controllers\App\ArticleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('articles')->group(function () {
    Route::get('', [ArticleController::class, 'index'])->name('app.dashboard.articles');
    Route::get('/create', [ArticleController::class, 'create'])->name('app.dashboard.articles.create');
    Route::post('/create', [ArticleController::class, 'store'])->name('app.dashboard.articles.store');
    Route::get('/edit/{article}', [ArticleController::class, 'edit'])->name('app.dashboard.articles.edit');
    Route::put('/edit/{article}', [ArticleController::class, 'update'])->name('app.dashboard.articles.update');
});