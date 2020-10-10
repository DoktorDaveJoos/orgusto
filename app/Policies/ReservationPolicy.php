<?php

namespace App\Policies;

use App\Reservation;
use App\Restaurant;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any reservation.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the reservation.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $this->onlyRegisteredOrElseDenyWithMessage($user, 'Only registered user are allowed to view reservations.');
    }

    /**
     * Determine whether the user can create a reservation.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user)
    {
        return $this->onlyRegisteredOrElseDenyWithMessage($user, 'Only registered user are allowed to create reservations.');
    }

    /**
     * Determine whether the user can update a reservation.
     *
     * @param User $user
     * @param Reservation $reservation
     * @return Response
     */
    public function update(User $user, Reservation $reservation)
    {
        // Only if user is user of corresponding restaurant.
        $restaurant = $reservation->tables()->first()->restaurant()->first();
        $userRestaurant = $user->firstRestaurant();
        return $userRestaurant->id === $restaurant->id
            ? Response::allow()
            : Response::deny('Only admins or users of the restaurant are allowed to update the reservations.');
    }

    private function onlyRegisteredOrElseDenyWithMessage(User $user, $message)
    {
        return $user->type === 'registered'
            ? Response::allow()
            : Response::deny($message);
    }
}
