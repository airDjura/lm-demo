<?php

    use Faker\Generator as Faker;

    $factory->define(\App\Models\Client\Venue::class, function(Faker $faker) {
        return [
            'name' => $faker->country,
        ];
    });

    $factory->afterCreating(App\Models\Client\Venue::class, function($item, $faker) {
        $item->address()
             ->save(factory(App\Models\Client\Address::class)->make());
    });


