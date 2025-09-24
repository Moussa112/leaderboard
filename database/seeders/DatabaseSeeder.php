<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();

        Game::factory()->count(50)->create();

        // update users elo from matches, naive but fine for seeding
        foreach (Game::all() as $m) {
            $winner = $m->winner;
            $loser = $m->loser;
            $winner->elo_rating = $m->winner_new_elo;
            $loser->elo_rating = $m->loser_new_elo;
            $winner->save();
            $loser->save();
        }
    }
}
