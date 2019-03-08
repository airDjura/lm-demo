<?php

    namespace App\Models\Client;

    class Player extends MainModel {
        protected static $sluggable = [
            'from' => ['name'],
        ];

        protected $dates = [
            'birthDate',
        ];

        protected $fillable = [
            'firstName',
            'lastName',
            'middleName',
            'birthDate',
            'email',
            'club_id',
        ];

        public function toSearchableArray() {
            return [
                'client_id'  => $this->client_id,
                'licenceCode' => $this->licenceCode,
                'firstName'  => $this->firstName,
                'lastName'   => $this->lastName,
                'middleName' => $this->middleName,
                'birthDate' => $this->birthDate->format('Y'),
                'email'      => $this->email,
                'club'       => $this->club ? $this->club->name : null,
            ];
        }

        public function club() {
            return $this->belongsTo(Club::class);
        }

        public function teams() {
            return $this->belongsToMany(Team::class);
        }

        public function getFullName() {
            if ($this->middleName) {
                return $this->lastName . ' ' . $this->middleName . ' ' . $this->firstName;
            }

            return $this->lastName . ' ' . $this->firstName;
        }
    }
