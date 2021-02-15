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
        $restaurant = $this->getRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurants.show');
        }

        if ($request->get('search')) {
            $user_ids = $restaurant->users()->get()->pluck('id');

            $query = Reservation::search($request->get('search'));
            $user_ids->each(function ($item) use ($query) {
                $query->where('user_id', $item);
            });

        } else {
            $query = Reservation::whereHas('tables', function ($q) use ($restaurant) {
                $q->where('restaurant_id', $restaurant->id);
            });
        }
        $this->buildQueryFromRequest($request, $query);

        $reservations = $query->paginate();

        if (request()->wantsJson()) {
            return ReservationResource::collection($reservations);
        }
        return view('reservations');
    }

    private function buildQueryFromRequest($request, $query)
    {
        if (!$request->get('done')) {
            $query->where('done', 0);
        }

        if (!$request->get('past')) {
            if ($request->get('from')) {
                $query->where('start', '>=', $request->get('from'));
            } else {
                $query->where('start', '>=', Carbon::today());
            }

            if ($request->get('to')) {
                $to = Carbon::parse($request->get('to'))->endOfDay();
                $query->where('start', '<=', $to);
            }
        }

    }


    public function show(Reservation $reservation)
    {
        if (request()->wantsJson()) {
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


        if ($request->wantsJson()) {
            return response()->json([
                'status' => 200
            ]);
        }

        return response(null, self::STATUS_NO_CONTENT);
    }

    public function done(Reservation $reservation)
    {
        try {
            $reservation->done = !$reservation->done;
            $reservation->save();
            return response(null, self::STATUS_NO_CONTENT);
        } catch (\Exception $e) {
            return response('Reservation could not be updated', self::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return response(null, self::STATUS_NO_CONTENT);
        } catch (\Exception $e) {
            return response('Resource with id: <' . $reservation->id . '> could not be deleted.', self::STATUS_INTERNAL_SERVER_ERROR);
        }
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
            ->withReservationsBetween($start_date, $end_date)->get();

        $tablesAlreadyBooked->whenNotEmpty(function ($tables) use ($reservation, $end_date, $start_date) {
            foreach ($tables as $table) {
                foreach ($table['reservations'] as $item) {
                    if (!$this->justBumping($item, $start_date, $end_date)) {
                        if ($reservation === null || $item->id !== $reservation->id) {
                            abort(self::STATUS_BAD_REQUEST,
                                'Table number: ' . $table->table_number . ' is blocked by reservation: ' . $item->name);
                        }
                    }
                }
            }
        });
    }

    private function justBumping($reservation, $start, $end)
    {
        // the reservation just starts at the end - so its okay:
        if ($end->isSameMinute(Carbon::parse($reservation->start))) {
            return true;
        }
        // the reservation ends at the start - so its okay:
        if (Carbon::parse($reservation->start)->addMinutes($reservation->duration)->isSameMinute($start)) {
            return true;
        }
        return false;
    }
}
