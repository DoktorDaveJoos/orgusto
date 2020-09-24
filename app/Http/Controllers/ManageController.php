<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use App\Reservation;
use Illuminate\Http\Request;


class ManageController extends Controller
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

    public function someTesting(CreateReservation $r)
    {




    }

    public function index(Request $request)
    {

        $actualRestaurant = auth()->user()->restaurants()->with('users')->first();
        $employees = $actualRestaurant->users ?? [];

        $tables = [];
        $date = $request->get('date') ?? date('Y-m-d');
        $from = date($date . " 00:00:00");
        $to = date($date . " 23:59:59");
        $scopedHour = $request->get('hour') ?? 17;

        if ($actualRestaurant) {
            $tables = $actualRestaurant->tables()->with(['reservations' => function ($query) use ($from, $to) {
                $query->whereBetween('start', [$from, $to]);
            }])->sortByTableNumber()->get();
        }

        if ($request->wantsJson()) {
            return $tables;
        }


        return view('manage', ['tables' => $tables, 'date' => $date, 'scopedHour' => $scopedHour, 'employees' => $employees]);
    }
}
