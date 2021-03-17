<?php

namespace Database\Factories;

use App\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @param int $ownerId
     * @return array
     */
    public function definition($ownerId = 1)
    {
        return [
            'name' => $this->faker->name,
            'owner_id' => $ownerId,
            'contact_email' => $this->faker->email,
        ];
    }

    /**
     * Indicate that the restaurant should have a subscription plan.
     *
     * @param string $planId
     * @return Factory
     */
    public function withSubscription($planId = null)
    {
        return $this->afterCreating(function ($restaurant) use ($planId) {
            $subscription = $restaurant->subscriptions()->create([
                'name' => 'default',
                'stripe_id' => Str::random(10),
                'stripe_status' => 'active',
                'stripe_plan' => $planId,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]);

            $subscription->items()->create([
                'stripe_id' => Str::random(10),
                'stripe_plan' => $planId,
                'quantity' => 1,
            ]);
        });
    }
}
