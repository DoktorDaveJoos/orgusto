<?php

namespace Tests\Feature;

use App\Reservation;
use App\Restaurant;
use App\Table;
use App\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AbstractTestSetup extends TestCase
{
    use RefreshDatabase;

    const TEST_USER_ID = 9999;
    const TEST_RESTAURANT_ID = 9999;
    const TEST_RESTAURANT_NAME = 'test_restaurant';

    private $isAdmin = true;

    public function setupUser(): User
    {
        return User::factory()->create([
            'id' => self::TEST_USER_ID,
        ]);
    }

    public function setupRandomUser(): User
    {
        return User::factory()->create([
            'id' => self::TEST_USER_ID - 1,
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
            'id' => self::TEST_RESTAURANT_ID,
        ]);
    }

    function setupRestaurantWithSubscription(): void
    {
        Restaurant::factory()
            ->withSubscription('Standard')
            ->create([
                'name' => self::TEST_RESTAURANT_NAME,
                'id' => self::TEST_RESTAURANT_ID,
            ]);
    }

    /**
     * Creates a User with a Restaurant.
     * The user has admin rights and the restaurant is subscribed.
     *
     * @return User - The {@code User} which has a {@code Restaurant} with 10 {@code Table}'s.
     */
    function buildTestSetup(): User
    {
        $testUser = [
            'id' => self::TEST_USER_ID,
        ];

        $testRestaurant = [
            'name' => self::TEST_RESTAURANT_NAME,
            'id' => self::TEST_RESTAURANT_ID,
            'owner_id' => self::TEST_USER_ID,
        ];

        $user = User::factory()
            ->hasAttached(
                Restaurant::factory()
                    ->withSubscription('Standard')
                    ->state($testRestaurant)
                    ->has(Table::factory()->count(10))
                    ->create(),
                ['role' => $this->isAdmin ? 'admin' : 'user']
            )
            ->create($testUser);

        $user->selected_id = self::TEST_RESTAURANT_ID;

        return $user;
    }

    function withAdmin(bool $isAdmin): AbstractTestSetup
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    function createReservationRequestPayload($tableIds, string $name = 'test_reservation'): array
    {
        return [
            'start' => CarbonImmutable::now()
                ->setTime(17, 0)
                ->toISOString(),
            'persons' => 2,
            'user_id' => self::TEST_USER_ID,
            'duration' => 120,
            'tables' => $tableIds,
            'name' => $name,
            'email' => 'test@test.de',
            'color' => 'gray',
            'notice' => 'some notice',
            'phone_number' => '+49 172 2541810',
        ];
    }

    function createReservationForTable(): Reservation
    {
        return $reservation = Reservation::factory()->create([
            'user_id' => self::TEST_USER_ID,
        ]);
    }
}
