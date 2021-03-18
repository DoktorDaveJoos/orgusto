<?php

namespace Tests\Feature;

use App\Reservation;
use App\Table;

class ReservationTest extends AbstractTestSetup
{
    public function testCreateReservation()
    {
        $user = $this->buildTestSetup();

        $this->assertDatabaseHas('users', [
            'id' => self::TEST_USER_ID,
        ]);

        $this->assertDatabaseCount('reservations', 0);

        $table = Table::first();

        $reservation = $this->createReservationRequestPayload([$table->id]);

        $response = $this->actingAs($user)->post('/reservations', $reservation);

        $response->assertCreated();

        $this->assertDatabaseHas('reservations', [
            'name' => 'test_reservation',
        ]);
    }

    public function testReservationGetsNotCreatedBecauseTableIsAlreadyBooked()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload($table->id));
        $reservation->tables()->attach($table->id);

        $reservation2 = $this->createReservationRequestPayload([$table->id], 'second');

        $response = $this->actingAs($user)->post('/reservations', $reservation2);

        $response->assertStatus(400); // Bad Request

        $this->assertDatabaseMissing('reservations', [
            'name' => 'second',
        ]);
    }

    public function testViewReservation()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation->tables()->attach($table->id);

        $response = $this->actingAs($user)->get('/reservations/' . $reservation->id);

        $response->assertOk();
    }

    public function testReservationGetsUpdated()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));

        $reservation->tables()->attach($table->id);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);

        $updatedReservation = $this->createReservationRequestPayload([$table->id]);
        $updatedReservation['name'] = 'updated';

        $response = $this->actingAs($user)->put('/reservations/' . $reservation->id, $updatedReservation);

        $response->assertNoContent(); // updated

        $this->assertDatabaseHas('reservations', [
            'name' => 'updated',
        ]);
    }

    public function testReservationGetsNotUpdatedBecauseNewTimeFrameHasOtherReservation()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        // First reservation - today
        $reservation0 = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation0->tables()->attach($table->id);

        // Second reservation - tomorrow
        $reservation1 = Reservation::create($this->createReservationRequestPayload([$table->id], 'tomorrow'));
        $reservation1->start = $reservation1->start->addDay();
        $reservation1->tables()->attach($table->id);
        $reservation1->save();

        // Update first reservation, add one day to reservation start date
        $updatedReservation = $reservation0->toArray();
        $updatedReservation['start'] = $reservation0->start->addDay()->toDateTimeString();
        $updatedReservation['tables'] = [$table->id];

        $response = $this->actingAs($user)->put('/reservations/' . $reservation0->id, $updatedReservation);

        $response->assertStatus(400); // Bad Request
    }

    public function testDeleteReservation()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));

        $reservation->tables()->attach($table->id);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);

        $response = $this->actingAs($user)->delete('/reservations/' . $reservation->id);

        $response->assertNoContent(); // successfully deleted

        $this->assertSoftDeleted($reservation);
    }

    public function testReservationGetsNotDeletedFromRandomUser()
    {
        $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));

        $reservation->tables()->attach($table->id);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);

        $response = $this->actingAs($this->setupRandomUser())->delete('/reservations/' . $reservation->id);

        $response->assertForbidden();
    }

    public function testReservationGetsNotUpdatedFromRandomUser()
    {
        $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation->tables()->attach($table->id);

        $updatedReservation = $this->createReservationRequestPayload([$table->id]);
        $updatedReservation['name'] = 'updated';

        $response = $this->actingAs($this->setupRandomUser())->put(
            '/reservations/' . $reservation->id,
            $updatedReservation
        );

        $response->assertForbidden();
    }

    public function testReservationCantGetViewedByRandomUser()
    {
        $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation->tables()->attach($table->id);

        $response = $this->actingAs($this->setupRandomUser())->get('/reservations/' . $reservation->id);

        $response->assertForbidden();
    }

    public function testThatKeysInReservationAreAllPresentOnShow()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation->tables()->attach($table->id);
        $reservation->save();

        $response = $this->actingAs($user)->getJson('/reservations/' . $reservation->id);

        $response->assertExactJson([
            'data' => [
                'id' => $reservation->id,
                'start' => $reservation->start,
                'persons' => 2,
                'duration' => 120,
                'tables' => [
                    [
                        'id' => $table->id,
                        'seats' => $table->seats,
                        'table_number' => $table->table_number,
                        'description' => $table->description,
                        'room' => $table->room,
                    ],
                ],
                'name' => 'test_reservation',
                'email' => 'test@test.de',
                'color' => 'gray',
                'done' => 0,
                'notice' => 'some notice',
                'phone_number' => '+49 172 2541810',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => $user->type,
                    'role' => $user->firstRestaurant()->pivot->role,
                ],
            ],
        ]);
    }

    public function testThatKeysInReservationAreAllPresentOnIndex()
    {
        $user = $this->buildTestSetup();
        $table = Table::first();

        $reservation = Reservation::create($this->createReservationRequestPayload([$table->id]));
        $reservation->tables()->attach($table->id);
        $reservation->save();

        $response = $this->actingAs($user)->getJson('/reservations');

        $response->assertJsonFragment([
            'data' => [
                [
                    'id' => $reservation->id,
                    'start' => $reservation->start,
                    'persons' => 2,
                    'duration' => 120,
                    'tables' => [
                        [
                            'id' => $table->id,
                            'seats' => $table->seats,
                            'table_number' => $table->table_number,
                            'description' => $table->description,
                            'room' => $table->room,
                        ],
                    ],
                    'name' => 'test_reservation',
                    'email' => 'test@test.de',
                    'color' => 'gray',
                    'done' => 0,
                    'notice' => 'some notice',
                    'phone_number' => '+49 172 2541810',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'type' => $user->type,
                        'role' => $user->firstRestaurant()->pivot->role,
                    ],
                ],
            ],
        ]);
    }
}
