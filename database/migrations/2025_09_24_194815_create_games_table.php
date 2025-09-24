<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('winner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('loser_id')->constrained('users')->cascadeOnDelete();
            $table->integer('winner_old_elo');
            $table->integer('loser_old_elo');
            $table->integer('winner_new_elo');
            $table->integer('loser_new_elo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
