<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    //Accounts Routes
    Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AccountsController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/create', [AccountsController::class, 'create'])->name('accounts.create');
    Route::get('/accounts/{account}/edit', [AccountsController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{account}', [AccountsController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{account}', [AccountsController::class, 'destroy'])->name('accounts.destroy');

    //Clients Routes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    //Parameters Routes
    Route::get('/parameters', [ParameterController::class, 'index'])->name('parameters.index');
    Route::post('/parameters', [ParameterController::class, 'store'])->name('parameters.store');
    Route::get('/parameters/create', [ParameterController::class, 'create'])->name('parameters.create');
    Route::get('/parameters/{parameter}/edit', [ParameterController::class, 'edit'])->name('parameters.edit');
    Route::put('/parameters/{parameter}', [ParameterController::class, 'update'])->name('parameters.update');
    Route::delete('/parameters/{parameter}', [ParameterController::class, 'destroy'])->name('parameters.destroy');
});
