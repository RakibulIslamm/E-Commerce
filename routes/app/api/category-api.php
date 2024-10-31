<?php
use App\Http\Controllers\App\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/aggiorna_categorie', [CategoryController::class, 'update_api']);