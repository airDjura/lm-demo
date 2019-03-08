<?php

    namespace App\Models\Client;

    use App\Traits\Sluggable;
    use App\Traits\Updatable;
    use Laravel\Scout\Searchable;
    use Spatie\MediaLibrary\HasMedia\HasMedia;
    use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
    use Spatie\MediaLibrary\Models\Media;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class MainModel extends BaseModel implements HasMedia {
        use HasMediaTrait, Sluggable, Searchable, Updatable, SoftDeletes;

        protected static $updatableRelationships = [];

        public function searchableAs() {
            return client()->id . '_' . str_plural(snake_case(class_basename(get_class($this))));
        }

        public function registerMediaConversions(Media $media = null)
        {
            $this->addMediaConversion('thumb')
                 ->width(100)
                 ->height(100)
                 ->sharpen(10);

            $this->addMediaConversion('md')
                 ->width(300)
                 ->height(300)
                 ->sharpen(10);

            $this->addMediaConversion('lg')
                 ->width(500)
                 ->height(500)
                 ->sharpen(10);
        }

        protected static $sluggable = [
            'from' => ['name'],
        ];

        public function slug() {
            return $this->morphOne('App\Models\Client\Slug', 'entity');
        }

        public static function getAll() {
            return self::orderBy('name')
                       ->get();
        }
    }
