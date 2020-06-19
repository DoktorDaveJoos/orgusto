<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
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

        $this->middleware(function ($request, $next) {

            $request->restaurant = auth()->user()->restaurants()->first();

            if ($request->restaurant) {
                return $next($request);
            }

            if (request()->wantsJson()) {
                return '{"message": "No restaurants. Please create a Restaurant."}';
            }

            // No restaurants
            return view('restaurants');
        });
    }

    public function index(Request $request)
    {
        $from_date = $request->get('from') ?? date('Y-m-d');
        $to_date = $request->get('to') ?? date('Y-m-d');
        $from = date($from_date . " 00:00:00");
        $to = date($to_date . " 23:59:59");

        $searchQuery = $request->get('searchQuery');

        if (!$searchQuery) {
            $reservations = Reservation::whereHas('tables', function ($q) use ($request) {
                $q->where('restaurant_id', $request->restaurant->id);
            })->whereBetween('starting_at', [$from, $to])->closest()->simplePaginate(20);
        } else {
            $name_term = $name_term = '%' . $searchQuery . '%';
            $constraints = [
                ['name', 'like', $name_term],
                ['starting_at', '>=', $from],
                ['starting_at', '<=', $to]
            ];

            $found_by_name = Reservation::where($constraints)->get();
            $results = Reservation::search($searchQuery)->get();
            $reservations = $results
                ->filter(function ($reservation, $key) use ($from, $to) {
                    return $reservation->starting_at >= $from && $reservation->starting_at <= $to;
                })
                ->merge($found_by_name)
                ->unique();
        }

        if (request()->wantsJson()) {
            return $reservations;
        }

        return view('reservations', ['reservations' => $reservations]);
    }

    public function show(Reservation $reservation)
    {
        return view('reservations', ['reservations' => [$reservation]]);
    }

    public function store(CreateReservation $request)
    {
        $reservation = Reservation::create($request->validated());
        $reservation->tables()->attach($request->tables);
        $reservation->save();
    }

    public function update(Reservation $reservation)
    {
        // TODO
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
    }

    public function search(Request $request)
    {

        $results = [];
        $st = $request->searchQuery;
        $from = date($request->from . " 00:00:00");
        $to = date($request->to . " 23:59:59");

        $name_term = '%' . $st . '%';

        $constraints = [
            ['name', 'like', $name_term],
            ['starting_at', '>=', $from],
            ['starting_at', '<=', $to]
        ];

        $found_by_name = Reservation::where($constraints)->get();

        $results = Reservation::search($st)->get();

        $results = $results
            ->filter(function ($reservation, $key) use ($from, $to) {
                return $reservation->starting_at >= $from && $reservation->starting_at <= $to;
            })
            ->merge($found_by_name)
            ->unique()
            ->map(function ($hit) use ($st) {
                $expl_st = preg_split('/[" "]+/m', $st);

                foreach ($expl_st as $elem) {
                    $hit->name = preg_replace('/(' . $elem . ')/i', "<b>$1</b>", $hit->name);

                    if (strpos($hit->notice, $elem) !== false) {
                        $hit->notice = preg_replace('/(' . $elem . ')/i', "<b>$1</b>", $hit->notice);
                        $hit->found_notice = true;
                    }

                    if (strpos($hit->email, $elem) !== false) {
                        $hit->email = preg_replace('/(' . $elem . ')/i', "<b>$1</b>", $hit->email);
                        $hit->found_email = true;
                    }

                    if (strpos($hit->phone_number, $elem) !== false) {
                        $hit->phone_number = preg_replace('/(' . $elem . ')/i', "<b>$1</b>", $hit->phone_number);
                        $hit->found_phone_number = true;
                    }
                }
                return $hit;
            });

        if (request()->wantsJson()) {
            return $results;
        }

        return view('reservations', ['reservations' => $results]);
    }
}
