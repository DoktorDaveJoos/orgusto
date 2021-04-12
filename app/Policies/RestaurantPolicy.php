<?php

namespace App\Policies;

use App\Http\Requests\DeleteRestaurant;
use App\Restaurant;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class RestaurantPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any restaurants.
   *
   * @param User $user
   * @return mixed
   */
  public function viewAny(User $user)
  {
    return false;
  }

  /**
   * Determine whether the user can view the restaurant.
   *
   * @param User $user
   * @param Restaurant $restaurant
   * @return mixed
   */
  public function view(User $user, Restaurant $restaurant)
  {
    return $this->returnSuccessForAdmin($this->checkRestaurant($user, $restaurant));
  }

  /**
   * Determine whether the user can create restaurants.
   *
   * @param User $user
   * @return mixed
   */
  public function create(User $user)
  {
    return true;
  }

  /**
   * Determine whether the user can update the restaurant.
   *
   * @param Restaurant $restaurant
   * @return mixed
   */
  public function update(User $user, Restaurant $restaurant)
  {
    return $this->returnSuccessForAdmin($this->checkRestaurant($user, $restaurant));
  }

  /**
   * Determine whether the user can delete the restaurant.
   *
   * @param DeleteRestaurant $request
   * @param Restaurant $restaurant
   * @return mixed
   */
  public function delete(User $user, Restaurant $restaurant)
  {
    return $this->returnSuccessForAdmin($this->checkRestaurant($user, $restaurant));
  }

  /**
   * Determine whether the user can restore the restaurant.
   *
   * @param User $user
   * @param Restaurant $restaurant
   * @return mixed
   */
  public function restore(User $user, Restaurant $restaurant)
  {
    return $this->returnSuccessForAdmin($this->checkRestaurant($user, $restaurant));
  }

  /**
   * Determine whether the user can permanently delete the restaurant.
   *
   * @param User $user
   * @param Restaurant $restaurant
   * @return mixed
   */
  public function forceDelete(User $user, Restaurant $restaurant)
  {
    return false;
  }

  /**
   * Returns the restaurant including pivot data if restaurant belongs to authenticated user.
   *
   * @param User $user - the authenticated user.
   * @param Restaurant $restaurant - the restaurant that a CRUD operation is to be made on.
   * @return Model - the found restaurant.
   */
  private function checkRestaurant(User $user, Restaurant $restaurant)
  {
    return $user->restaurants()->find($restaurant->id);
  }

  /**
   * Returns allow() if pivot data says user is admin.
   *
   * @param Model $restaurant - the found restaurant with pivot data.
   * @return Response - the response.
   */
  private function returnSuccessForAdmin(Model $restaurant)
  {
    $pivot = $restaurant->pivot->role;
    return $pivot === 'admin' ? Response::allow() : Response::deny('You do not own this restaurant');
  }
}
