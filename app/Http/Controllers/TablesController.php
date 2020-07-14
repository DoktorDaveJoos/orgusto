<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailableTables;

class TablesController extends Controller
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

    public function index(GetAvailableTables $request)
    {
        $start_date = $request->get('start');
        $end_date = $request->get('end');
        $persons = $request->get('persons') ?? 0;

        $restaurant = auth()->user()->firstRestaurant();

        return $restaurant->tables()->availableBetween($start_date, $end_date)->withEnoughSeats($persons)->get();
    }
}
