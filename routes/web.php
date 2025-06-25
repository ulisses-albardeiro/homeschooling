<?php

use App\Http\Controllers\Plannings\CurricularPlanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('planning', [CurricularPlanController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('planning');

Route::get('new-planning', [CurricularPlanController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('new-planning');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
