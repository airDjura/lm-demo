<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Client\Address::class, function (Faker $faker) {
    return [
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'streetNumber' => $faker->numberBetween(1,50),
        'postCode' => $faker->postcode,
    ];
});
