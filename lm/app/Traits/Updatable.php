<?php

    namespace App\Traits;

    trait Updatable
    {
        protected static function bootUpdatable()
        {

            static::saved(function($model) {

                if (static::$updatableRelationships) {
                    $relations = static::$updatableRelationships;
                    foreach($relations as $relation) {
                        if($model->$relation) {
                            $model->$relation->searchable();
                        }
                    }
                }

            });
        }
    }
