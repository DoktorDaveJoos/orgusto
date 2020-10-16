<?php

namespace Database\Factories;

use App\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'duration' => $this->faker->randomElement([90, 120, 180]),
            'persons' => $this->faker->randomDigitNotNull,
            'start' => $this->faker->dateTimeBetween(
                CarbonImmutable::now(),
                CarbonImmutable::now()->addDays(7)
            ),
            'notice' => $this->faker->text,
            'color' => $this->faker->randomElement([
                'green', 'red', 'gray', 'blue'
            ]),
            'email' => $this->faker->safeEmail,
            'phone_number' => '01722541810',
            'user_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
