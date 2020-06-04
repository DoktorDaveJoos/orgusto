<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use App\Reservation;

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
        $actualRestaurant = auth()->user()->restaurants()->first();

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

    public function store(CreateReservation $request)
    {
        $reservation = Reservation::create($request->validated());
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
