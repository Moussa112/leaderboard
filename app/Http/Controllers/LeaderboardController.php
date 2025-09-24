<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Leaderboard', ['users' => User::orderByDesc('elo_rating')->get()]);
    }
}
