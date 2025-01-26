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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('championship_id');
            $table->unsignedBigInteger('stage_id'); 
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->integer('home_team_goals');
            $table->integer('away_team_goals');
            $table->integer('home_team_extra_time')->nullable();
            $table->integer('away_team_extra_time')->nullable();
            $table->integer('home_team_penalties')->nullable();
            $table->integer('away_team_penalties')->nullable();
            $table->unsignedBigInteger('winner_id');            
            $table->datetime('match_date');
            $table->timestamps();


            $table->foreign('championship_id')->references('id')->on('championships')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stage')->onDelete('cascade');
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('winner_id')->references('id')->on('teams')->onDelete('cascade');
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
