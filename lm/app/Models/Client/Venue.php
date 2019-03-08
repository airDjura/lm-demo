<?php

    namespace App\Models\Client;

    class Venue extends MainModel {
        protected $fillable = [
            'name',
        ];

        public function toSearchableArray() {
            return [
                'name' => $this->name,
            ];
        }
    }
