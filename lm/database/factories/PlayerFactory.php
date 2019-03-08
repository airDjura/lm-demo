<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Client\Player::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstNameMale,
        'lastName' => $faker->lastName,
        'birthDate' => $faker->date('Y-m-d', '-12 years'),
    ];
});
