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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $restaurants = auth()->user()->restaurants()->get();

        if($request->wantsJson()) {
            return $restaurants->toJSON();
        }

        return view('restaurants', ['restaurants' => $restaurants]);
    }

    public function show(Request $request, Restaurant $restaurant)
    {
        if ($request->wantsJson()) {
            return new RestaurantResource($restaurant);
        }

        return view('edit-restaurant', ['restaurant' => $restaurant]);
    }

    public function update(Restaurant $restaurant)
    {
        // NOOP so far
    }

    public function store(CreateRestaurant $request)
    {

        if (auth()->user()->restaurants()->get()->count() > 0) {
            $request->session()->flash('message', 'Right now it\'s not allowed to create more than one restaurant.');
            return redirect()->route('restaurants.show');
        }

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

    public function formDestroy(DeleteRestaurant $request,Restaurant $restaurant) {
        if ($request->validated()['name'] == $restaurant->name) {
            Restaurant::destroy($restaurant->id);
        }
        $request->session()->flash('message', 'Successfully deleted restaurant.');

        return redirect()->route('restaurants.show');
    }

    public function showTable(Request $request, Restaurant $restaurant, Table $table) {

        if ($request->wantsJson()) {
            return new TableResource($table);
        }

        return view('edit-table', ['restaurant' => $restaurant, 'table' => $table]);
    }
}
