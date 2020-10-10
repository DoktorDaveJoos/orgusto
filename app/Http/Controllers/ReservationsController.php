<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use Illuminate\Http\Request;
use App\Reservation;

class ReservationsController extends Controller
{

    const STATUS_CREATED = 201;


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

        //TODO: Refactor hardcore.


        $from_date = $request->get('from') ?? date('Y-m-d');
        $to_date = $request->get('to') ?? date('Y-m-d');
        $from = date($from_date . " 00:00:00");
        $to = date($to_date . " 23:59:59");
        $searchQuery = $request->get('searchQuery');

        $empty_search = false;
        $card_title = "Reservations";

        $reservations = [];

        $restaurant = auth()->user()->restaurants()->first();

        if ($restaurant) {
            if (!$searchQuery) {
                $reservations = Reservation::whereHas('tables', function ($q) use ($restaurant) {
                    $q->where('restaurant_id', $restaurant->id);
                })->whereBetween('start', [$from, $to])->with(['tables', 'user'])->closest()->simplePaginate(20);
            } else {
                $name_term = $name_term = '%' . $searchQuery . '%';
                $constraints = [
                    ['name', 'like', $name_term],
                    ['start', '>=', $from],
                    ['start', '<=', $to]
                ];

                $found_by_name = Reservation::where($constraints)->get();
                $results = Reservation::search($searchQuery)->get();
                $reservations = $results
                    ->filter(function ($reservation, $key) use ($from, $to) {
                        return $reservation->start >= $from && $reservation->start <= $to;
                    })
                    ->merge($found_by_name)
                    ->unique();
            }

            if (sizeof($reservations) < 1) {
                $empty_search = true;
                $card_title = "... upcoming reservations";
                $reservations = Reservation::where('start', '>', date('Y-m-d'))->with(['tables', 'user'])->paginate(15);
            }
        }

        if (request()->wantsJson()) {
            return $reservations;
        }

        return view('reservations', ['reservations' => $reservations, 'empty_search' => $empty_search, 'card_title' => $card_title]);
    }

    public function show(Reservation $reservation)
    {
        return view('reservations', ['reservations' => [$reservation]]);
    }

    public function store(CreateReservation $request)
    {
        $newReservation = $this->validateTables($request->validated());

        $reservation = Reservation::create($newReservation);
        $reservation->tables()->attach($newReservation['tables']);
        $reservation->save();

        return response(self::STATUS_CREATED);
    }

    public function update(CreateReservation $request, Reservation $reservation)
    {
        $newOrUpdatedReservation = $this->validateTables($request->validated());

        $reservation->update($request->validated());
        $reservation->tables()->sync($newOrUpdatedReservation['tables']);
        $reservation->save();

        return response(204);
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
            ['start', '>=', $from],
            ['start', '<=', $to]
        ];

        $found_by_name = Reservation::where($constraints)->withPivot('tables')->get();

        $results = Reservation::search($st)->withPivot('tables')->get();

        $results = $results
            ->filter(function ($reservation, $key) use ($from, $to) {
                return $reservation->start >= $from && $reservation->start <= $to;
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

    private function validateTables(Array $validated)
    {

//        $restaurant = $this->getRestaurant();
//
//        return $restaurant->tables()
//            ->availableBetween($start_date, $end_date)
//            ->get();

        $start_date = $validated['start'];

        $end_date = $start_date
            ->addMinutes($validated['duration']);

        $restaurant = $this->getRestaurant();

        $availableTables = $restaurant->tables()
            ->availableBetween($start_date, $end_date)
            ->get();

        foreach ($availableTables as $foundTable) {
            $test = $foundTable->name;
            if (in_array($foundTable->id, $validated['tables'])) {
                abort('Table with table number: ' . $test . ' already booked', 400);
            }
        }

        return $validated;
    }
}
