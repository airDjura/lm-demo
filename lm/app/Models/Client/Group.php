<?php

    namespace App\Models\Client;

    use App\Traits\DeleteRelatedRelationships;

    class Group extends BaseModel {
        use DeleteRelatedRelationships;

        protected static $deleteRelationships = [
            'games'
        ];

        protected $fillable = [
            'name',
        ];

        public function teams() {
            return $this->hasMany(Team::class);
        }

        public function games() {
            return $this->hasMany(Game::class);
        }
    }
