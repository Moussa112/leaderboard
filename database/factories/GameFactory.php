<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $players = User::inRandomOrder()->take(2)->get();

        return [
            'winner_id' => $players[0]->id,
            'loser_id' => $players[1]->id,
            'winner_old_elo' => $players[0]->elo_rating,
            'loser_old_elo' => $players[1]->elo_rating,
            'winner_new_elo' => $players[0]->elo_rating + 10,
            'loser_new_elo' => $players[1]->elo_rating - 10,
        ];
    }
}
