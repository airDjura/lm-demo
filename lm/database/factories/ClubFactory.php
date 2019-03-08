<?php

    use Faker\Generator as Faker;

    $factory->define(\App\Models\Client\Club::class, function(Faker $faker) {
        return [
            'name'    => $faker->unique()->company,
            'website' => $faker->domainName,
        ];
    });

    $factory->afterCreating(App\Models\Client\Club::class, function($item, $faker) {
        $item->players()
             ->saveMany(factory(App\Models\Client\Player::class, 20)->make());
    });
