<?php

namespace App\Models\Client;

use App\Traits\DeleteRelatedRelationships;
use App\Traits\UpdateSchedule;

class Team extends SeasonBaseModel
{
    use DeleteRelatedRelationships, UpdateSchedule;

    protected static $deleteRelationships = [
        'gamesAsHome',
        'gamesAsAway',
    ];

    protected $fillable = [
        'schedule_id',
        'group_id',
        'club_id',
        'suffix',
        'out_of_competition',
    ];

    public function club() {
        return $this->belongsTo(Club::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function gamesAsHome()
    {
        return $this->hasMany(Game::class, 'teamA');
    }

    public function gamesAsAway()
    {
        return $this->hasMany(Game::class, 'teamB');
    }

    public function games() {
        return $this->gamesAsHome()->union($this->gamesAsAway());
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function players() {
        return $this->belongsToMany(Player::class);
    }

    public function teamPlayers() {
        return $this->hasMany(PlayerTeam::class);
    }

    public function getName() {
        if($this->suffix) {
            return $this->club->name . ' - ' . $this->suffix;
        }
        return $this->club->name;
    }
}
