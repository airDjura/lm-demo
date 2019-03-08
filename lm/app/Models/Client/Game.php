<?php

    namespace App\Models\Client;

    use Illuminate\Database\Eloquent\Model;

    class Game extends BaseModel {
        protected $fillable = [
            'teamA',
            'teamB',
        ];

        public $tenantColumns = ['client_id', 'season_id'];

        public function group() {
            return $this->belongsTo(Group::class);
        }

        public function schedule() {
            return $this->belongsTo(Schedule::class);
        }
        public function homeTeam() {
            return $this->belongsTo(Team::class, 'teamA');
        }

        public function awayTeam() {
            return $this->belongsTo(Team::class, 'teamB');
        }
    }
