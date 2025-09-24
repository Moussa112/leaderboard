<?php

namespace App\Services;

use App\Models\User;

class EloService
{
    protected $k = 32;

    public function expectedScore($ratingA, $ratingB)
    {
        return 1 / (1 + pow(10, ($ratingB - $ratingA) / 400));
    }

    public function newRating($rating, $expected, $score)
    {
        return (int) round($rating + $this->k * ($score - $expected));
    }

    public function recordGame(User $winner, User $loser)
    {
        $winnerOld = $winner->elo_rating;
        $loserOld = $loser->elo_rating;

        $expectedWin = $this->expectedScore($winnerOld, $loserOld);
        $expectedLose = $this->expectedScore($loserOld, $winnerOld);

        $winnerNew = $this->newRating($winnerOld, $expectedWin, 1);
        $loserNew = $this->newRating($loserOld, $expectedLose, 0);

        $winner->elo_rating = $winnerNew;
        $loser->elo_rating = $loserNew;

        $winner->save();
        $loser->save();

        return [
            'winner_old' => $winnerOld,
            'winner_new' => $winnerNew,
            'loser_old' => $loserOld,
            'loser_new' => $loserNew,
        ];
    }
}
