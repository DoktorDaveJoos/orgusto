<?php

namespace Tests\Feature;

use App\Reservation;
use App\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends AbstractTestSetup
{
    public function testCreateReservation()
    {
        $user = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID
        ]);

        $table = Table::first();

        $reservation = $this->createReservationRequestPayload($table->id);

        $response = $this->actingAs($user)
            ->post('/reservations', $reservation);

        $response->assertStatus(201); // created
    }

    public function testReservationGetsUpdated()
    {
        $user = $this->buildTestSetup();

        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload($table->id));

        $reservation->tables()->attach($table->id);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id
        ]);

        $updatedReservation = $this->createReservationRequestPayload($table->id);
        $updatedReservation['name'] = 'updated';

        $response = $this->actingAs($user)
            ->put('/reservations/'.$reservation->id, $updatedReservation);

        $response->assertStatus(200);

        $this->assertDatabaseHas('reservations', [
            'name' => 'updated'
        ]);

    }

    public function testReservationGetsNotCreatedBecauseTableIsAlreadyBooked()
    {
        $user = $this->buildTestSetup();

        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload($table->id));
        $reservation->tables()->attach($table->id);

        $reservation2 = $this->createReservationRequestPayload($table->id);

        $response = $this->actingAs($user)
            ->post('/reservations', $reservation2);

        $response->assertStatus(400); // created
    }

}
