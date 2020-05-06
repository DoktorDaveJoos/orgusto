<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Reservation;
use App\Restaurant;

class ReservationsController extends Controller
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
        $actualRestaurant = Restaurant::where('id', auth()->user()->selected_restaurant)->first();

        if ($actualRestaurant->id) {

            $reservations = Reservation::whereHas('tables', function ($q) use ($actualRestaurant) {
                $q->where('restaurant_id', $actualRestaurant->id);
            })->closest()->simplePaginate(20);

            if (request()->wantsJson()) {
                return $reservations;
            }

            $tables = $actualRestaurant->tables()->sortByTableNumber()->get();

            return view('reservations', ['reservations' => $reservations, 'tables' => $tables]);
        }

        // No restaurants
        return view('restaurants');
    }

    public function store(Request $request)
    {
        $request->validate([
            'starting_at' => 'required|date',
            'accepted_from' => 'required',
            'person_count' => 'required',
            'length' => 'required',
            'tables' => 'required',
            'name' => 'required',
        ]);

        $reservation = Reservation::create($request->all());
        $reservation->tables()->attach($request->tables);
        $reservation->save();
    }

    public function show(Reservation $reservation)
    {
        return $reservation->name;
    }

    public function update(Reservation $reservation)
    {
        $reservation->update(request()->validate([]));

        $reservation->name = "10";
        $reservation->save();
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
    }
}
