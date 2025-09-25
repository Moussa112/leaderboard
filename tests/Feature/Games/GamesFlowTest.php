<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GamesFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_record_a_game_and_update_elo()
    {
        $winner = User::factory()->create(['elo_rating' => 1200]);
        $loser = User::factory()->create(['elo_rating' => 1200]);


        $this->actingAs($winner)
        ->post(route('games.store'), [
        'winner_id' => $winner->id,
        'loser_id' => $loser->id,
        ])
        ->assertRedirect(route('leaderboard'));


        $this->assertDatabaseCount('games', 1);


        $winner->refresh();
        $loser->refresh();


        $this->assertNotEquals(1200, $winner->elo_rating);
        $this->assertNotEquals(1200, $loser->elo_rating);
        $this->assertGreaterThan($loser->elo_rating, $winner->elo_rating);
    }

    /** @test */
    public function loser_cannot_be_same_as_winner()
    {
        $user = User::factory()->create();


        $this->actingAs($user)
        ->post(route('games.store'), [
        'winner_id' => $user->id,
        'loser_id' => $user->id,
        ])
        ->assertSessionHasErrors('loser_id');
    }

    /** @test */
    public function only_authenticated_users_can_record_games()
    {
        $users = User::factory()->count(2)->create();

        $this->post(route('games.store'), [
            'winner_id' => $users[0]->id,
            'loser_id' => $users[1]->id,
            ])->assertRedirect(route('login'));
    }
}
