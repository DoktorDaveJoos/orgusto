<?php

namespace Tests\Feature;

use App\Table;

class TableTest extends AbstractTestSetup
{
    public function testTableResourceShow()
    {
        $user = $this->withAdmin(true)->buildTestSetup();

        $restaurant = $user->firstRestaurant();

        $table = Table::first();

        $response = $this->actingAs($user)->getJson('/restaurants/' . $restaurant->id . '/' . $table->id);

        $response->assertExactJson([
            'data' => [
                'id' => $table->id,
                'seats' => $table->seats,
                'table_number' => $table->table_number,
                'description' => $table->description,
                'room' => $table->room,
            ],
        ]);
    }
}
