<?php

namespace Tests\Feature;

use App\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends AbstractTestSetup
{
    /**
     * Test restaurant is created.
     *
     * @return void
     */
    public function testRestaurantCreated()
    {
        $this->setupSingleRestaurant();

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }
}
