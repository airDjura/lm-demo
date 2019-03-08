<?php

    namespace App\Models\Client;

    use Hyn\Tenancy\Traits\UsesTenantConnection;
    use Illuminate\Database\Eloquent\Model;
    use App\Traits\UUIDable;

    class BaseModel extends Model {
        use UUIDable, UsesTenantConnection;

        public static function getByUuid($uuid) {
            $item = self::where('uuid', $uuid)->first();

            if (!is_object($item)) {
                throw new \HttpResponseException(response(getClassText(static::class) . ' does not exists', 404));
            }

            return $item;
        }

        public function phones() {
            return $this->morphMany('App\Models\Client\Phone', 'entity');
        }

        public function address() {
            return $this->morphOne('App\Models\Client\Address', 'entity');
        }

        public static function random(int $take = 1) {
            if ($take == 1) {
                return self::inRandomOrder()
                           ->first();
            }
            else {
                return self::inRandomOrder()
                           ->take($take)
                           ->get();
            }
        }

        public static function searchBy(?string $q, ?string $searchBy = 'name', int $limit = 10) {
            $search = $q ?? '';

            $item = self::where($searchBy, 'LIKE', '%' . $search . '%')
                        ->limit($limit)
                        ->get();

            return $item;
        }
    }
