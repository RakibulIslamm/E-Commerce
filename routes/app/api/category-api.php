<?php
use App\Http\Controllers\App\Dashboard\CategoryController;

Route::post('/aggiorna_categorie', [CategoryController::class, 'update_api']);