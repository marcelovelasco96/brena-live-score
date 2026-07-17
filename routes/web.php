<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchGameController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('matches.index')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('matches.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Overlay público (OBS / YoloBox)
|--------------------------------------------------------------------------
*/

Route::get('/overlay/{match}', [MatchGameController::class, 'overlay'])
    ->name('matches.overlay');

Route::get('/overlay/{match}/data', [MatchGameController::class, 'overlayData'])
    ->name('matches.overlayData');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/matches', [MatchGameController::class, 'index'])->name('matches.index');
    Route::get('/matches/create', [MatchGameController::class, 'create'])->name('matches.create');
    Route::post('/matches', [MatchGameController::class, 'store'])->name('matches.store');
    Route::get('/matches/{match}/control', [MatchGameController::class, 'control'])->name('matches.control');

    Route::get('/matches/{match}/settings', [MatchGameController::class, 'settings'])->name('matches.settings');
    Route::patch('/matches/{match}/settings', [MatchGameController::class, 'updateSettings'])->name('matches.updateSettings');

    Route::patch('/matches/{match}/score', [MatchGameController::class, 'updateScore'])->name('matches.updateScore');
    Route::patch('/matches/{match}/period', [MatchGameController::class, 'updatePeriod'])->name('matches.updatePeriod');
    Route::patch('/matches/{match}/status', [MatchGameController::class, 'updateStatus'])->name('matches.updateStatus');
    Route::patch('/matches/{match}/timer', [MatchGameController::class, 'updateTimer'])->name('matches.updateTimer');
    Route::patch('/matches/{match}/volleyball', [MatchGameController::class, 'updateVolleyball'])
        ->name('matches.updateVolleyball');

    Route::patch('/matches/{match}/penalties', [MatchGameController::class, 'updatePenalties'])
        ->name('matches.updatePenalties');

    Route::patch('/matches/{match}/banner', [MatchGameController::class, 'updateBanner'])
        ->name('matches.updateBanner');
});

require __DIR__ . '/auth.php';
