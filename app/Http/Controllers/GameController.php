<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Services\EloService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    public function __construct(readonly protected EloService $elo)
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id','name','elo_rating']);

        return Inertia::render('Games/Create', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'winner_id' => 'required|exists:users,id',
            'loser_id' => 'required|exists:users,id|different:winner_id',
        ]);

        $winner = User::findOrFail($data['winner_id']);
        $loser = User::findOrFail($data['loser_id']);

        $changes = Elo::recordGale($winner, $loser);

        $game = Game::create([
            'winner_id' => $winner->id,
            'loser_id' => $loser->id,
            'winner_old_elo' => $changes['winner_old'],
            'loser_old_elo' => $changes['loser_old'],
            'winner_new_elo' => $changes['winner_new'],
            'loser_new_elo' => $changes['loser_new'],
        ]);

        return redirect()->route('leaderboard')->with('success', 'Game recorded.');
    }
}
