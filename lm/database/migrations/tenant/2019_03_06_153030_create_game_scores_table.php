<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->integer('home_team_first_period')->nullable();
            $table->integer('home_team_second_period')->nullable();
            $table->integer('home_team_third_period')->nullable();
            $table->integer('home_team_fourth_period')->nullable();
            $table->integer('home_team_over_time')->nullable();
            $table->integer('away_team_first_period')->nullable();
            $table->integer('away_team_second_period')->nullable();
            $table->integer('away_team_third_period')->nullable();
            $table->integer('away_team_fourth_period')->nullable();
            $table->integer('away_team_over_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_scores');
    }
}
