<?php

use App\Http\Controllers\CentralApp\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CentralApp\Auth\ConfirmablePasswordController;
use App\Http\Controllers\CentralApp\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\CentralApp\Auth\EmailVerificationPromptController;
use App\Http\Controllers\CentralApp\Auth\NewPasswordController;
use App\Http\Controllers\CentralApp\Auth\PasswordController;
use App\Http\Controllers\CentralApp\Auth\PasswordResetLinkController;
use App\Http\Controllers\CentralApp\Auth\RegisteredUserController;
use App\Http\Controllers\CentralApp\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('central.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('central.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('central.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('central.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('central.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('central.password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('central.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('central.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('central.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('central.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('central.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('central.logout');
});
