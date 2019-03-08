<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->index();
            $table->integer('season_id')->index();
            $table->integer('schedule_id')->index();
            $table->integer('venue_id')->index();
            $table->integer('group_id')->index();
            $table->integer('teamA')->index()->nullable();
            $table->integer('teamB')->index()->nullable();
            $table->integer('round')->nullable();
            $table->enum('status', ['NOT_PLAYED', 'LIVE', 'SCHEDULED', 'ARCHIVED'])->default('NOT_PLAYED');
            $table->boolean('isPlayoff')->default(false);
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
        Schema::dropIfExists('games');
    }
}
