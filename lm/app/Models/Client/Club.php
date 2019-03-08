<?php

    namespace App\Models\Client;

    class Club extends MainModel {
        protected static $updatableRelationships = [
            'players',
        ];

        protected $fillable = [
            'name',
            'email',
            'phone',
            'website',
            'fb',
            'tw',
            'insta',
        ];

        public function toSearchableArray() {
            return [
                'name'    => $this->name,
                'email'   => $this->email,
                'phone'   => $this->phone,
                'website' => $this->website,
            ];
        }

        public function players() {
            return $this->hasMany(Player::class);
        }
    }
