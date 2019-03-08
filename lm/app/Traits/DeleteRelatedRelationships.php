<?php

    namespace App\Traits;

    trait DeleteRelatedRelationships
    {
        protected static function bootDeleteRelatedRelationships()
        {

            static::deleting(function($model) {

                if (static::$deleteRelationships) {
                    $relations = static::$deleteRelationships;
                    foreach($relations as $relation) {
                        if($model->$relation) {
                            $model->$relation()->delete();
                        }
                    }
                }

            });
        }
    }
