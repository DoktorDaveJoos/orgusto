<?php

namespace Database\Factories;

use App\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'restaurant_id' => $this->faker->randomDigit,
            'seats' => $this->faker->randomElement([2, 4, 8, 10]),
            'table_number' => $this->faker->unique()->randomDigit
        ];
    }
}
