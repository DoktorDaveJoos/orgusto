<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Restaurant;

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

    public function index(Request $request)
    {

        $date = $request->get('date') ?? date('Y-m-d');
        $from = date($date . " 00:00:00");
        $to = date($date . " 23:59:59");

        $scopedHour = $request->get('hour') ?? 17;

        $actualRestaurant = Restaurant::where('id', auth()->user()->selected_restaurant)->first();

        $tables = $actualRestaurant->tables()->with(['reservations' => function ($query) use ($from, $to) {
            $query->whereBetween('starting_at', [$from, $to]);
        }])->sortByTableNumber()->get();

        return view('manage', ['tables' => $tables, 'date' => $date, 'scopedHour' => $scopedHour]);
    }
}
