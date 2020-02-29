<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Table::class, function (Faker $faker) {
    return [
        'table_number' => $faker->randomDigitNotNull(),
        'seats' => $faker->randomDigitNot(0),
        'description' => $faker->text,
        'restaurant_id' => 1
    ];
});
