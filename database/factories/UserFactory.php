<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'registered',
            'password' => bcrypt('test'),
            'name' => $this->faker->name,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
