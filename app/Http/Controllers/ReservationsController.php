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

        return view('home', ['reservations' => $reservations]);
    }

    public function store(Request $request)
    {

        $reservation = Reservation::create($request->validate([
            'name'          => 'required|max:100',
            'person_count'  => 'required|between:1,900',
            'starting_at'   => 'date',
            'length'        => 'digits_between:0,24',
            'accepted_from' => 'required',
        ]));

        // $reservation->attributes['user_id'] = Auth::id();

        $reservation->save();

        return 'success';

        

        // if (!$reservation) {
        //     abort('500');
        // }
        // return view('home', ['reservations' => Reservation::closes()->paginate(20)]);

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

    public function destroy($reservation)
    {
    }
}
