<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRestaurant;
use App\Http\Requests\DeleteRestaurant;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\TableResource;
use App\Restaurant;
use App\Table;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

  public function index(Request $request)
  {
    return RestaurantResource::collection($request->user()->restaurants());
  }

  public function show(Restaurant $restaurant)
  {
    return new RestaurantResource($restaurant);
  }

  public function update(Restaurant $restaurant)
  {
    // NOOP so far
  }

  public function store(CreateRestaurant $request)
  {
    $user = $request->user();

    $restaurant = Restaurant::create([
      'name' => $request->validated()['name'],
      'owner_id' => $user->id,
    ]);

    // Add creator as owner
    $restaurant->owner = $user;

    // Make creator 'admin' automatically
    $user->restaurants()->attach($restaurant->id, ['role' => 'admin']);

    // Set fresh created restaurant as selected_restaurant
    $user->selected_id = $restaurant->id;
    $user->save();

    return new RestaurantResource($restaurant);
  }

  public function destroy(DeleteRestaurant $request, Restaurant $restaurant)
  {
    $usersOfRestaurant = $restaurant->users;

    $usersOfRestaurant->each(function ($user) use ($restaurant) {
      if ($user->selected_id === $restaurant->id) {
        $alternative = $user->firstRestaurant()->id;
        $user->selected_id = $alternative ? $alternative : null;
        $user->save();
      }
    });

    // Only Owner can delete restaurant
    if ($request->validated()['name'] === $restaurant->name && $restaurant->owner->id === auth()->user()->id) {
      // Cancel Subscription
      if (optional($restaurant->subscription())->recurring() && 'testing' !== app()->environment()) {
        $restaurant->subscription()->cancelNow();
      }

      // Delete Restaurant
      Restaurant::destroy($restaurant->id);
      $request->session()->flash('message', __('messages.deleted_restaurant'));
      return redirect()->route('restaurants.show');
    } else {
      $request->session()->flash('message', __('messages.deleted_not_restaurant'));
      return redirect()->route('restaurants.show');
    }
  }
}
