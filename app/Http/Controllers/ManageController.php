<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use App\Http\Resources\TableResource;
use App\Reservation;
use Carbon\CarbonImmutable;
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

//        $from = $this->getStartFromRequest($request)->toDate();
//        $to = $this->getEndFromRequest($request)->toDate();

//        $tables = $restaurant->tables()->with(['reservations' =>
//            function ($query) use ($from, $to) {
//                $query->whereBetween('start', [$from, $to])->with(['user', 'reservations']);
//            }])->sortByTableNumber()->get();

        if ($request->wantsJson()) {
            return TableResource::collection($restaurant->tables);
        }

        return view('manage');
    }
}
