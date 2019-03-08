<?php

    namespace App;

    use App\Models\Client;
    use App\Models\Client\Season;
    use App\Traits\Sluggable;
    use Illuminate\Support\Collection;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;
    use App\Traits\UUIDable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Spatie\MediaLibrary\HasMedia\HasMedia;
    use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

    /**
     * @OA\Schema(
     *      required={"firstName","email"},
     *  )
     */
    class User extends Authenticatable implements HasMedia {
        use Sluggable, Notifiable, UUIDable, HasMediaTrait, HasApiTokens;

        protected $connection = 'system';

        protected static $sluggable = [
            'from' => ['firstName', 'lastName'],
        ];

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'firstName',
            'lastName',
            'isVerified',
            'email',
            'password',
            'client_id',
            'role_id',
            'inAdmin',
        ];

        public function client() {
            return $this->belongsTo(Client::class);
        }

        public function slug() {
            return $this->morphOne('App\Models\Client\Slug', 'entity');
        }

        public static function getByUuid($uuid) {
            $item = self::where('uuid', $uuid)
                        ->first();

            return $item;
        }

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        public function fullName() {
            return $this->firstName . ' ' . $this->lastName;
        }

        public function season() {
            return $this->belongsTo(Season::class, 'editSeason');
        }

        // static
        public static function searchByName(string $q) {
            if (strlen($q) > 2) {
                $item = self::where('lastName', 'LIKE', '%' . $q . '%')
                            ->orWhere('firstName', 'LIKE', '%' . $q . '%')
                            ->get();
            }
            else {
                $item = new Collection;
            }

            return $item;
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

        public static function getByEmail(string $email) {
            return self::where('email', $email)
                       ->first();
        }

        public function getFullName() {
            if ($this->lastName) {
                return $this->firstName . ' ' . $this->lastName;
            }

            return $this->firstName;
        }
    }


    /**
     * @OA\Property(
     *      property="firstName",
     *      type="string",
     *  ),
     * @OA\Property(
     *      property="lastName",
     *      type="string",
     *  ),
     * @OA\Property(
     *      property="isVerified",
     *      type="boolean",
     *  ),
     * @OA\Property(
     *      property="email",
     *      type="string",
     *  ),
     *
     */

    /**
     *
     * @OA\RequestBody(
     *      request="User",
     *      description="User object",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/User"
     *              ),
     *          )
     *      )
     *  )
     */
