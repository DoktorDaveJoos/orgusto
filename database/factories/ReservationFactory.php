<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'created_at' => now(),
        'notice' => $faker->text,
        'persons' => $faker->randomDigitNotNull,
        'user_id' => 1,
        'start' => $faker->randomElement($array = array(
            '2020-07-06 17:00:00',
            '2020-07-06 19:00:00'
        )),
        'end' => $faker->randomElement($array = array(
            '2020-07-06 20:00:00',
            '2020-07-06 21:00:00'
        )),
        'color' => $faker->randomElement($array = array(
            'green',
            'red',
            'gray',
            'blue'
        )),
        'duration' => "{\"h\": \"2\", \"m\": \"00\"}",
    ];
});
