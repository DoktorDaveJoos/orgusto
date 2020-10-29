<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use App\Http\Resources\TableResource;
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

    public function index(Request $request)
    {

        $restaurant = $this->getRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurants.show');
        }

        $employees = $restaurant->users ?? array();

        $scopedHour = $request->get('hour') ?? 17;

        $date = $request->get('date') ?? date('Y-m-d');

        $from = $this->getStartFromRequest($request);
        $to = $this->getEndFromRequest($request);

        $tables = $restaurant->tables()->with(['reservations' =>
            function ($query) use ($from, $to) {
                $query->whereBetween('start', [$from, $to]);
            }])->sortByTableNumber()->get();

        if ($request->wantsJson()) {
            return TableResource::collection($tables);
        }

        return view('manage', ['tables' => $tables, 'date' => $date, 'scopedHour' => $scopedHour, 'employees' => $employees]);
    }
}
