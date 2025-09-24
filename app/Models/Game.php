<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_id',
        'loser_id',
        'winner_old_elo',
        'loser_old_elo',
        'winner_new_elo',
        'loser_new_elo',
    ];

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function loser()
    {
        return $this->belongsTo(User::class, 'loser_id');
    }
}
