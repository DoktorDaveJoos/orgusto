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

        $employees = $restaurant->users ?? array();

        $date = $request->has('date') ? CarbonImmutable::parse($request->get('date')) : CarbonImmutable::now()->setTime(16, 0);

        $from = $this->getStartFromRequest($request)->toDate();
        $to = $this->getEndFromRequest($request)->toDate();

        $tables = $restaurant->tables()->with(['reservations' =>
            function ($query) use ($from, $to) {
                $query->whereBetween('start', [$from, $to])->with(['user', 'tables']);
            }])->sortByTableNumber()->get();

        if ($request->wantsJson()) {
            return TableResource::collection($tables);
        }

        $scope = $date->get('hour');

        return view('manage', ['tables' => $tables, 'date' => $date->toISOString(), 'scopedHour' => $scope, 'employees' => $employees]);
    }
}
