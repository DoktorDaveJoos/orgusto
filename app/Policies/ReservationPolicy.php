<?php

namespace App\Policies;

use App\Reservation;
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
   * Determine whether the user can create a reservation.
   *
   * @param User $user
   * @return Response
   */
  public function create(User $user)
  {
    return $this->onlyRegisteredOrElseDenyWithMessage(
      $user,
      'Only registered user are allowed to create reservations.'
    );
  }

  /**
   * Determine whether the user can view a reservation.
   *
   * @param User $user
   * @param Reservation $reservation
   * @return Response
   */
  public function view(User $user, Reservation $reservation)
  {
    return $this->onlyUsersOfTheRestaurantOrElseDenyWithMessage(
      $user,
      $reservation,
      'Only admins or users of the restaurant are allowed to view this reservation.'
    );
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
    return $this->onlyUsersOfTheRestaurantOrElseDenyWithMessage(
      $user,
      $reservation,
      'Only admins or users of the restaurant are allowed to update the reservations.'
    );
  }

  /**
   * Determine whether the user can delete a reservation.
   *
   * @param User $user
   * @param Reservation $reservation
   * @return Response
   */
  public function delete(User $user, Reservation $reservation)
  {
    return $this->onlyUsersOfTheRestaurantOrElseDenyWithMessage(
      $user,
      $reservation,
      'Only admins or users of the restaurant are allowed to delete reservations.'
    );
  }

  /**
   * Allows request if user generally registered.
   *
   * @param User $user - the user
   * @param $message - the message if not allowed
   * @return Response
   */
  private function onlyRegisteredOrElseDenyWithMessage(User $user, $message)
  {
    return $user->type === 'registered' ? Response::allow() : Response::deny($message);
  }

  /**
   * Allows request if user is registered for the restaurant of the reservation.
   *
   * @param User $user - the user
   * @param Reservation $reservation - the reservation
   * @param string $message - The message if not allowed
   * @return Response
   */
  private function onlyUsersOfTheRestaurantOrElseDenyWithMessage(User $user, Reservation $reservation, string $message)
  {
    $restaurant = $reservation
      ->tables()
      ->first()
      ->restaurant()
      ->first();
    $userRestaurant = $user->firstRestaurant();
    if (!$userRestaurant) {
      return Response::deny($message);
    }
    return $userRestaurant->id === $restaurant->id ? Response::allow() : Response::deny($message);
  }
}
