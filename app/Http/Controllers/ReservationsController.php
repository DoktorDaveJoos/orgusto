<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservation;
use App\Table;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\Reservation;
use App\Http\Resources\ReservationResource;
use Illuminate\Support\Carbon;

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
    }

    public function index(Request $request)
    {
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
                $reservations = Reservation::where('start', '>', date('Y-m-d'))->with('user')->paginate(15);
            }
        }

        if (request()->wantsJson()) {
            return ReservationResource::collection($reservations);
        }

        return view('reservations', ['reservations' => $reservations, 'empty_search' => $empty_search, 'card_title' => $card_title]);
    }

    public function show(Reservation $reservation)
    {
        if (request()->wantsJson()){
            return new ReservationResource($reservation);
        }

        $reservations = Reservation::where('id', $reservation->id)->with('user')->paginate(15);

        return view('reservations', ['reservations' => $reservations, 'empty_search' => false, 'card_title' => 'Found:']);
    }

    public function store(CreateReservation $request)
    {
        $newReservation = $request->validated();
        $this->validateTables($newReservation['start'],
            $newReservation['duration'], $newReservation['tables']);

        $reservation = Reservation::create($newReservation);
        $reservation->tables()->attach($newReservation['tables']);
        $reservation->save();

        return response(null, self::STATUS_CREATED);
    }

    public function update(CreateReservation $request, Reservation $reservation)
    {
        $updatedReservation = $request->validated();
        $this->validateTables($updatedReservation['start'],
            $updatedReservation['duration'], $updatedReservation['tables'],
            $reservation);

        $reservation->update($updatedReservation);
        $reservation->tables()->sync($updatedReservation['tables']);
        $reservation->save();

        return response(null, self::STATUS_NO_CONTENT);
    }

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return response(null, self::STATUS_NO_CONTENT);
        } catch (\Exception $e) {
            return response('Resource with id: <'. $reservation->id .'> could not be deleted.', self::STATUS_INTERNAL_SERVER_ERROR);
        }
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

        $found_by_name = Reservation::where($constraints)->get();

        $results = Reservation::search($st)->get();

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

    /**
     * Checks if given tables are available in period (start_date -> start_date + duration).
     * Aborts the request if tables are not available.
     *
     * @param mixed $start_date - The start date.
     * @param int $duration - Duration in minutes.
     * @param array $tables - Array of tables to check.
     * @param Reservation|null $reservation - The (optional) Reservation to check against.
     */
    private function validateTables($start_date, int $duration,
                                    array $tables, Reservation $reservation = null): void
    {
        if (!($start_date instanceof Carbon) || !($start_date instanceof CarbonImmutable)) {
            $start_date = CarbonImmutable::parse($start_date);
        }

        $end_date = $start_date
            ->addMinutes($duration);

        $tablesAlreadyBooked = Table::where('id', $tables)
            ->withReservationsBetween($start_date, $end_date)
            ->with('reservations')->get();

        $tablesAlreadyBooked->whenNotEmpty(function ($tables) use ($reservation) {
            if ($reservation === null) {
                abort(self::STATUS_BAD_REQUEST,
                    'Table with table number: ' . $tables->first()->table_number . ' already booked');
            } else {
                foreach ($tables as $table) {
                    foreach ($table->reservations as $bookedReservation) {
                        if ($bookedReservation->id !== $reservation->id) {
                            abort(self::STATUS_BAD_REQUEST,
                                'Table with table number: ' . $tables->first()->table_number . ' already booked');
                        } // else -> it's not another reservation, updating is fine.
                    }
                }
            }
        });
    }
}
