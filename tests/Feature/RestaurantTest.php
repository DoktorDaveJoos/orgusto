<?php

namespace Tests\Feature;

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
        $premiumUser = $this->setupUserWithPremiumAccess(true);

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
            'access_level' => 'premium'
        ]);

        $response = $this->actingAs($premiumUser)
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
        $premiumUser = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
            'access_level' => 'premium'
        ]);

        $response = $this->actingAs($premiumUser)
            ->delete('/restaurants/' . self::TEST_RESTAURANT_ID, ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('restaurants', [
            'id' => self::TEST_RESTAURANT_ID
        ]);
    }

    public function testRestaurantCantBeCreatedFromFreeUser()
    {
        $freeUser = $this->setupUserWithPremiumAccess(false);

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
            'access_level' => 'free'
        ]);

        $response = $this->actingAs($freeUser)
            ->post('/restaurants', ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('restaurants', [
            'name' => self::TEST_RESTAURANT_NAME
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
        $user = $this
            ->withAdmin(true)
            ->withPremium(true)->buildTestSetup();

        $restaurant = $user->firstRestaurant();

        $response = $this->actingAs($user)
            ->getJson('/restaurants/' . $restaurant->id);

        $response->assertExactJson([
            'data' => [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'table_count' => $restaurant->table_count,
                'contact_email' => $restaurant->contact_email,
                'owner' => $restaurant->owner,
                'street' => $restaurant->street,
                'zip_code' => $restaurant->zip_code,
                'street_number' => $restaurant->street_number,
                'city' => $restaurant->city,
                'default_table_seats' => $restaurant->default_table_seats,
                'seat_reservation_bound' => $restaurant->seat_reservation_bound
            ]
        ]);
    }

}
