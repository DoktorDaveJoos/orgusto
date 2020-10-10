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
        $response->assertStatus(302);

        $this->assertDatabaseHas('restaurants', [
            'name' => self::TEST_RESTAURANT_NAME
        ]);
    }

    public function testRestaurantGetsUpdated()
    {
        $premiumUser = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
            'access_level' => 'premium'
        ]);

        $response = $this->actingAs($premiumUser)
            ->put('/restaurants/'.self::TEST_RESTAURANT_ID, ['name' => 'updated']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID,
            'name' => 'updated'
        ]);
    }

    public function testRestaurantGetsDeleted()
    {
        $premiumUser = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
            'access_level' => 'premium'
        ]);

        $response = $this->actingAs($premiumUser)
            ->delete('/restaurants/'.self::TEST_RESTAURANT_ID, ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertStatus(302);
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

        $response->assertStatus(403); // forbidden

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
            ->put('/restaurants/'.self::TEST_RESTAURANT_ID, ['name' => 'updated']);

        $response->assertStatus(403); // forbidden

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
            ->delete('/restaurants/'.self::TEST_RESTAURANT_ID, ['name' => self::TEST_RESTAURANT_NAME]);

        $response->assertStatus(403); // forbidden

        $this->assertDatabaseHas('restaurants', [
            'id' => self::TEST_RESTAURANT_ID,
            'name' => self::TEST_RESTAURANT_NAME
        ]);
    }

}
