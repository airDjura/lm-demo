<?php

namespace App\Models;

use App\User;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Database\Eloquent\Model;

class Client extends Website
{
    protected $connection = 'system';

    protected $fillable = [
        'name',
    ];

    public static function create($name, $email, $password): Client {
        //Set Database security to LOW
        // app(Connection::class)->statement("SET GLOBAL validate_password_policy=LOW");

        // Create New Website

        $client = new Client;
        $client->name = $name;

        app(WebsiteRepository::class)->create($client);

        // associate the website with a hostname

        // make hostname current
        app(Environment::class)->tenant($client);

        \App\User::create([
                              'firstName'         => 'Administrator',
                              'client_id'         => $client->id,
                              'lastName'          => '',
                              'role_id'           => 1,
                              'email'             => $email,
                              'email_verified_at' => now(),
                              'password'          => \Illuminate\Support\Facades\Hash::make($password),
                              'remember_token'    => str_random(10),
                              'editSeason'        => null,
                          ]);

        return $client;
    }

    public static function getByUuid($uuid) {
        $item = self::where('uuid', $uuid)
                    ->first();

        if (!is_object($item)) {
            throw new \HttpResponseException(response(getClassText(static::class) . ' does not exists', 404));
        }

        return $item;
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
