<?php

    namespace App\Traits;

    use App\Models\Client\Season;

    trait CurrentSeason {
        protected static function bootCurrentSeason() {
            static::saved(function($model) {
                if ($model->isCurrent) {
                    Season::where('id', '!=', $model->id)
                          ->update([
                                       'isCurrent' => false,
                                   ]);
                }
            });
        }
    }
