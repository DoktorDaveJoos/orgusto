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
        'starting_at' => $faker->randomElement($array = array(
            '2020-02-25 17:15:00',
            '2020-02-25 17:30:00',
            '2020-02-25 18:00:00',
            '2020-02-25 18:45:00',
            '2020-02-25 19:30:00',
            '2020-02-25 19:00:00'
        )),
        'color' => $faker->randomElement($array = array(
            'green',
            'red',
            'gray',
            'blue'
        )),
        'length' => '2',
        'tables' => $faker->randomElements($array = array (1, 2, 3, 4, 5), $count = 1),
        'accepted_from' => $faker->name
    ];
});
