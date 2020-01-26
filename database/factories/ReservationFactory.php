<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => 1,
        'created_at' => now(),
        'notice' => $faker->text,
        'person_count' => $faker->randomDigitNotNull,
        'starting_at' => $faker->dateTimeBetween(
            $startDate = 'now',
            $endDate = '+ 1 days'
        ),
        'length' => '2',
        'accepted_from' => $faker->name
    ];
});
