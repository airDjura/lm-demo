<?php

    namespace App\Models\Client;

    use App\Traits\CurrentSeason;

    class Season extends MainModel {
        use CurrentSeason;

        protected $fillable = [
            'name',
            'isCurrent',
        ];

        public static function getCurrentAdminSeason() {
            return auth()->user()->season;
        }

        public function toSearchableArray() {
            return [
                'name' => $this->name,
            ];
        }
    }
