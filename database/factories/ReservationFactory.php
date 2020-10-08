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
            'duration' => 120,
            'created_at' => now(),
            'name' => $this->faker->name,
            'notice' => $this->faker->text,
            'color' => $this->faker->randomElement([
                'green', 'red', 'gray', 'blue'
            ]),
            'start' => $this->faker->dateTimeBetween(
                CarbonImmutable::now(),
                CarbonImmutable::now()->addDays(7)
            ),
            'persons' => $this->faker->randomElement([2, 3, 4]),
        ];
    }
}
