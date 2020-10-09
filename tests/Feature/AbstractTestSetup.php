<?php

namespace Tests\Feature;

use App\Restaurant;
use App\Table;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use phpDocumentor\Reflection\Types\Boolean;
use Tests\TestCase;

abstract class AbstractTestSetup extends TestCase
{
    use RefreshDatabase;
    const TEST_USER_ID = 9999;
    const TEST_RESTAURANT_ID = 9999;
    const TEST_RESTAURANT_NAME = 'test_restaurant';

    private $isPremium = true;
    private $isAdmin = true;

    /**
     * Creates a User with {@link #TEST_USER_ID} as ID.
     *
     * @param bool $isPremium - indicates if {@code User} is allowed to create a {@code Restaurant}
     * @return User - the created User
     */
    public function setupUserWithPremiumAccess(bool $isPremium): User
    {
        return User::factory()->create([
            'id' => self::TEST_USER_ID,
            'access_level' => $isPremium ? 'premium' : 'free'
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
            'name' => self::TEST_RESTAURANT_NAME,
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }

    /**
     * Creates a User with a Restaurant.
     * The user has admin rights and premium access.
     *
     * @return User - The {@code User} which has a {@code Restaurant} with 10 {@code Table}'s.
     */
    function buildTestSetup(): User
    {
        $testUser = [
            'id' => self::TEST_USER_ID,
            'access_level' => $this->isPremium ? 'premium' : 'free'
        ];

        $testRestaurant = [
            'name' => self::TEST_RESTAURANT_NAME,
            'id' => self::TEST_RESTAURANT_ID
        ];

        return User::factory()->hasAttached(
            Restaurant::factory()
                ->state($testRestaurant)
                ->has(Table::factory()->count(10)),
            ['role' => $this->isAdmin ? 'admin' : 'user']
        )->create($testUser);

    }

    function withPremium(bool $isPremium): AbstractTestSetup
    {
        $this->isPremium = $isPremium;
        return $this;
    }

    function withAdmin(bool $isAdmin): AbstractTestSetup
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

}

