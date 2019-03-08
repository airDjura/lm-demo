<?php

    namespace App\Models\Client;

    class League extends MainModel {
        protected $fillable = [
            'name',
        ];

        public function toSearchableArray() {
            return [
                'name' => $this->name,
            ];
        }
    }
