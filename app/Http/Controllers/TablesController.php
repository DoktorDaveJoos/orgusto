<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailableTables;
use Carbon\CarbonImmutable;

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
        $start_date = CarbonImmutable::createFromDate($request->get('start'));

        $end_date = $start_date
            ->addMinutes($request->get('m'));

        $persons = $request->get('persons') ?? 0;

        $restaurant = $this->getRestaurant();

//        return $query->whereDoesntHave('reservations', function ($q) use ($from, $to) {
//            $q->whereBetween('start', [$from, $to])->orWhereBetween('end', [$from, $to]);
//        });

//        $withReservations = $restaurant->tables()->whereHas('reservations', function($q) use($start_date, $end_date) {
//            $q->whereBetween('start', [$start_date->toDate(), $end_date->toDate()]);
//        })->with('reservations')->get();

//        return $withReservations;


        return $restaurant->tables()
            ->availableBetween($start_date, $end_date)
            ->get();
    }

}
