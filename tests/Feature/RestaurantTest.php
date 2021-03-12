<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\User;

class RestaurantTest extends AbstractTestSetup
{
    public function testRestaurantCreated()
    {
        $this->setupSingleRestaurant();

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }

    public function testRestaurantGetsCreated()
    {
        $user = $this->setupUser();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
        ]);

        $response = $this->actingAs($user)
            ->post('/restaurants', ['name' => self::TEST_RESTAURANT_NAME]);

        // expect 302 because if succeeded, you will be redirected to detail page with new restaurant
        $response->assertRedirect();

        $this->assertDatabaseHas('restaurants', [
            'name' => self::TEST_RESTAURANT_NAME
        ]);
    }

    // TODO: Route not implemented
//    public function testRestaurantGetsUpdated()
//    {
//        $premiumUser = $this->buildTestSetup();
//
//        $this->assertDatabaseHas('users', [
//            'id' => self::TEST_USER_ID,
//            'access_level' => 'premium'
//        ]);
//
//        $response = $this->actingAs($premiumUser)
//            ->put('/restaurants/' . self::TEST_RESTAURANT_ID, ['name' => 'updated']);
//
//        $response->assertOk();
//
//        $response = $this->actingAs($premiumUser)
//            ->getJson('/restaurants/' . self::TEST_RESTAURANT_ID);
//
//        $response->dump();
//
//        $this->assertDatabaseHas('restaurants', [
//            'id' => self::TEST_RESTAURANT_ID,
//            'name' => 'updated'
//        ]);
//    }

    public function testRestaurantGetsDeleted()
    {
        $user = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
        ]);

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);

        $response = $this->actingAs($user)
            ->delete('/restaurants/' . self::TEST_RESTAURANT_ID, ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertSoftDeleted('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }

    public function testRestaurantCantBeUpdatedFromNonAdmin()
    {
        $freeUser = $this->withAdmin(false)->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
        ]);

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);

        $response = $this->actingAs($freeUser)
            ->put('/restaurants/' . self::TEST_RESTAURANT_ID, ['name' => 'updated']);

        $response->assertForbidden();

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID,
            'name' => self::TEST_RESTAURANT_NAME
        ]);
    }

    public function testRestaurantCantBeDeletedFromNonAdmin()
    {
        $freeUser = $this->withAdmin(false)->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
        ]);

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);

        $response = $this->actingAs($freeUser)
            ->delete('/restaurants/' . self::TEST_RESTAURANT_ID, ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertForbidden();

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID,
            'name' => self::TEST_RESTAURANT_NAME
        ]);
    }

    public function testRestaurantResourceShow()
    {
        $user = $this->withAdmin(true)->buildTestSetup();

        $restaurant = $user->firstRestaurant();

        $response = $this->actingAs($user)
            ->getJson('/restaurants/' . $restaurant->id);

        $response->assertJsonFragment([
            'data' => [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'contact_email' => $restaurant->contact_email,
                'owner' => [
                    'email' => $restaurant->owner->email,
                    'id' => $restaurant->owner->id,
                    'name' => $restaurant->owner->name,
                    'role' => 'admin',
                    'type' => $restaurant->owner->type,
                ],
                'default_table_seats' => $restaurant->default_table_seats,
                'seat_reservation_bound' => $restaurant->seat_reservation_bound
            ]
        ]);
    }

}
