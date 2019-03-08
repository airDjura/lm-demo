<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'host' => $faker->domainName,
    ];
});
