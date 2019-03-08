<?php

    namespace App\Models\Client;

    use Illuminate\Database\Eloquent\Model;

    class Slug extends Model {
        public function entity() {
            return $this->morphTo();
        }
    }
