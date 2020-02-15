<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        $reservations = Reservation::closest()->simplePaginate(20);

        return view('reservations', ['reservations' => $reservations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'person_count' => 'required',
            'starting_at' => 'required|date',
            'length' => 'required',
            'accepted_from' => 'required'
        ]);

        $reservation = Reservation::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        $reservation->save();
    }

    public function create() {
        return view('create');
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
