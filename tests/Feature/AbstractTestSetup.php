<?php

namespace Tests\Feature;

use App\Restaurant;
use App\Table;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AbstractTestSetup extends TestCase
{
    use RefreshDatabase;
    const TEST_USER_ID = 9999;
    const TEST_RESTAURANT_ID = 9999;

    /**
     * Creates a User with {@link #TEST_USER_ID} as ID.
     *
     * @return void
     */
    public function setupSingleUser(): void
    {
        User::factory()->create([
            'id' => self::TEST_USER_ID
        ]);
    }

    /**
     * Creates a Restaurant with {@link #TEST_RESTAURANT_ID} as ID.
     *
     * @return void
     */
    function setupSingleRestaurant(): void
    {
        Restaurant::factory()->create([
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }

    function setupTestEnvironment(): void
    {

        $testUser = [
            'id' => self::TEST_USER_ID
        ];

        $testRestaurant = [
            'id' => self::TEST_RESTAURANT_ID
        ];

        User::factory()->hasAttached(
            Restaurant::factory()
                ->state($testRestaurant)
                ->has(Table::factory()->count(10)),
            ['role' => 'admin']
        )->create($testUser);

    }



}
