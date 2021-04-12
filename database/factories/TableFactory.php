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
      'table_number' => $this->faker->randomDigit,
      'restaurant_id' => 1,
      'seats' => $this->faker->randomElement([2, 4, 8, 10]),
      'description' => $this->faker->text,
    ];
  }
}
