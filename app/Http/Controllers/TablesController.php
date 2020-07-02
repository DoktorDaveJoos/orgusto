<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;

use Carbon\Carbon;

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

    public function index(Request $request)
    {
        $start_date = new Carbon($request->get('date'));
        $duration = $request->get("duration");

        $tables = [];

        if ($start_date && $duration) {
            $end_date = clone $start_date;

            $start_date = $start_date->toDateTimeString();
            $end_date = $end_date->addHours($duration)->toDateTimeString();

            $persons = $request->get('persons') ?? 0;

            $before = [
                ['start', '<', $start_date],
                ['end', '<=', $start_date],
            ];

            $after = [
                ['start', '>=', $end_date],
                ['end', '>', $end_date]
            ];

            $restaurant = auth()->user()->restaurants()->first();

            $tables = $restaurant->tables()->where('seats', '>=', $persons)->doesntHave('reservations')
                ->orWhereHas('reservations', function ($q) use ($before, $after) {
                    $q->where($before)->orWhere($after);
                })->where('seats', '>=', $persons)->get();
        }

        return $tables;
    }
}
