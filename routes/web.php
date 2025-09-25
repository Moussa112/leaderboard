<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
});

Route::get('/', function () { return redirect()->route('leaderboard'); })->name('home');

require __DIR__.'/auth.php';
