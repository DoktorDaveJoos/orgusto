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
        // Livewire.
    }

    public function store(CreateRestaurant $request)
    {
        // $this->authorize('create');

        $new_restaurant = Restaurant::create($request->validated());
        // Make creator 'admin' automatically
        auth()->user()->restaurants()->attach($new_restaurant->id, ['role' => 'admin']);

        if ($request->wantsJson()) {
            return $new_restaurant;
        }

        return redirect()->route('restaurant.show', ['restaurant' => $new_restaurant->id]);
    }

    public function destroy(DeleteRestaurant $request, Restaurant $restaurant)
    {
        if ($request->validated()['name'] == $restaurant->name) {
            Restaurant::destroy($restaurant->id);
        }

        return redirect()->route('restaurants.show');
    }
}
