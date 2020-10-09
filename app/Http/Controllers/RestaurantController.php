<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRestaurant;
use App\Http\Requests\DeleteRestaurant;
use App\Restaurant;

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

    public function update(Restaurant $restaurant)
    {
        // See livewire/edit-restaurant
    }

    public function store(CreateRestaurant $request)
    {
        $restaurant = Restaurant::create($request->validated());

        // Make creator 'admin' automatically
        auth()->user()->restaurants()->attach($restaurant->id, ['role' => 'admin']);

        if ($request->wantsJson()) {
            return $restaurant;
        }
        return redirect()->route('restaurant.show', ['restaurant' => $restaurant->id]);
    }

    public function destroy(DeleteRestaurant $request, Restaurant $restaurant)
    {
        if ($request->validated()['name'] == $restaurant->name) {
            Restaurant::destroy($restaurant->id);
        }
        $request->session()->flash('message', 'Successfully deleted restaurant.');

        return redirect()->route('restaurants.show');
    }
}
