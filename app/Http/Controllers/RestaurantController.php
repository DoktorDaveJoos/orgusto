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
        $restaurants = auth()
            ->user()
            ->restaurants()
            ->get();

        if ($request->wantsJson()) {
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

        if ($request->wantsJson()) {
            return $restaurant;
        }

        $request->session()->flash('message', 'Dein Restaurant ' . $restaurant->name . ' wurde erfolgreich angelegt.');
        return redirect()->route('restaurant.show', ['restaurant' => $restaurant->id]);
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

    public function select(Restaurant $restaurant)
    {
        $user = auth()->user();
        $user->selected_id = $restaurant->id;
        $user->save();

        return back();
    }

    public function showTable(Request $request, Restaurant $restaurant, Table $table)
    {
        if ($request->wantsJson()) {
            return new TableResource($table);
        }

        return view('edit-table', ['restaurant' => $restaurant, 'table' => $table]);
    }
}
