<?php

    namespace App\Traits;

    use App\Models\Client\Group;

    trait ScheduleGroup {
        protected static function bootScheduleGroup() {
            static::created(function($model) {
                $group = new Group([
                                       'name'      => 'A',
                                   ]);
                $model->groups()
                      ->save($group);
            });
        }
    }
