<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
});

Route::get('/', function () { return redirect()->route('leaderboard'); })->name('home');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
