<?php

    namespace App\Traits;

    use App\Models\Slug;

    trait Sluggable {
        protected static function bootSlugable() {
            static::saved(function($model) {
                $from = static::$sluggable['from'];
                $string = '';

                foreach ($from as $field) {
                    $string .= str_replace('/', '-', $model->{$field} . ' ');
                }

                $slug = str_slug($string);
                $countQuery = Slug::where('entity_type', get_class($model))
                                  ->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'");

                if ($model->slug) {
                    $countQuery->where('entity_id', '!=', $model->id);
                }

                $count = $countQuery->count();

                $slug = $count ? $slug . '-' . $count : $slug;

                if ($model->slug) {
                    $newSlug = $model->slug;
                    $newSlug->slug = $slug;
                    $newSlug->is301 = true;
                }
                else {
                    $newSlug = new Slug;
                    $newSlug->slug = $slug;
                    $newSlug->is301 = false;
                }

                $model->slug()
                      ->save($newSlug);
            });
        }
    }
