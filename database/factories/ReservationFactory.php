<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'created_at' => now(),
        'notice' => $faker->text,
        'person_count' => $faker->randomDigitNotNull,
        'starting_at' => $faker->randomElement($array = array(
            '2020-02-26 17:00:00',
            '2020-02-26 19:00:00'
        )),
        'color' => $faker->randomElement($array = array(
            'green',
            'red',
            'gray',
            'blue'
        )),
        'length' => $faker->randomElements($array = array (1.5,2,1), $count = 1),
        'accepted_from' => $faker->name
    ];
});
