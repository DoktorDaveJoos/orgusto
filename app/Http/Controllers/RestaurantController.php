<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRestaurant;
use App\Http\Requests\DeleteRestaurant;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurants = auth()->user()->restaurants()->get();
        return view('restaurants', ['restaurants' => $restaurants]);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        // See livewire/edit-restaurant
    }

    public function store(CreateRestaurant $request)
    {

        $user = auth()->user();

        if ($user->can('create', Restaurant::class)) {
            $new_restaurant = Restaurant::create($request->validated());
            // Make creator 'admin' automatically
            $user->restaurants()->attach($new_restaurant->id, ['role' => 'admin']);

            if ($request->wantsJson()) {
                return $new_restaurant;
            }

            return redirect()->route('restaurant.show', ['restaurant' => $new_restaurant->id]);
        }

        return redirect()->route('restaurants.show')->withErrors(['Something went wrong. Please contact service team.']);
    }

    public function destroy(DeleteRestaurant $request, Restaurant $restaurant)
    {

        if (auth()->user()->can('delete', $restaurant)) {
            if ($request->validated()['name'] == $restaurant->name) {
                Restaurant::destroy($restaurant->id);
            }

            $request->session()->flash('message', 'Successfully deleted restaurant.');
            return redirect()->route('restaurants.show');
        }

        return redirect()->route('restaurants.show')->withErrors(['Something went wrong. Please contact service team.']);
    }
}
