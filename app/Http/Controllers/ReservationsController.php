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
      $user_ids = $restaurant
        ->users()
        ->get()
        ->pluck('id');

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

  public function scoped(Request $request)
  {
    $restaurant = $this->getRestaurant();

    $from = $this->getStartFromRequest($request);
    $to = $this->getEndFromRequest($request);

    $reservations = Reservation::whereHas('tables', function ($q) use ($restaurant) {
      $q->where('restaurant_id', $restaurant->id);
    })
      ->whereBetween('start', [$from, $to])
      ->get();

    return ReservationResource::collection($reservations);
  }

  private function buildQueryFromRequest($request, $query)
  {
    if (!$request->get('done')) {
      $query->where('done', 0);
    }
  }

  public function filterOutByRequest($request, $query)
  {
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

    $reservations = Reservation::where('id', $reservation->id)
      ->with('user')
      ->paginate(15);

    return view('reservations', [
      'reservations' => $reservations,
      'empty_search' => false,
      'card_title' => 'Found:',
    ]);
  }

  public function store(CreateReservation $request)
  {
    $newReservation = $request->validated();

    $this->validateTables($newReservation);

    $reservation = Reservation::create($newReservation);
    $reservation->tables()->attach($newReservation['tables']);

    return response(null, self::STATUS_CREATED);
  }

  public function update(CreateReservation $request, Reservation $reservation)
  {
    $updated = $request->validated();

    $this->validateTables($updated, $reservation->id);

    $reservation->update($updated);
    $reservation->tables()->sync($updated['tables']);

    if ($request->wantsJson()) {
      return response()->json([
        'status' => 200,
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
      return response(
        'Resource with id: <' . $reservation->id . '> could not be deleted.',
        self::STATUS_INTERNAL_SERVER_ERROR
      );
    }
  }

  /**
   * Checks if given tables are available in period (start_date -> start_date + duration).
   * Aborts the request if tables are not available.
   *
   * @param $updated - The reservation.
   * @param null $existing_id
   */
  private function validateTables($updated, $existing_id = null): void
  {
    $start = CarbonImmutable::parse($updated['start']);
    $end = $start->addMinutes($updated['duration']);

    $tables = Table::whereIn('id', $updated['tables'])
      ->withReservationsBetween($start, $end)
      ->get();

    // Remove all bumping reservations
    $tables->each(function ($table) use ($start, $end) {
      $table['reservations'] = $table['reservations']->filter(function ($reservation) use ($start, $end) {
        return !$this->justBumping($reservation, $start, $end);
      });
    });

    // Check if left reservations are it-self
    $tables->each(function ($table) use ($updated, $existing_id) {
      $table['reservations']->each(function ($reservation) use ($updated, $table, $existing_id) {
        if ($reservation->id !== $existing_id) {
          abort(
            self::STATUS_BAD_REQUEST,
            'Table number: ' . $table->table_number . ' is blocked by reservation: ' . $reservation->name
          );
        }
      });
    });
  }

  private function justBumping($reservation, $start, $end)
  {
    // the reservation just starts at the end - so its okay:
    if ($end->isSameMinute(Carbon::parse($reservation->start))) {
      return true;
    }
    // the reservation ends at the start - so its okay:
    if ($reservation->start->addMinutes($reservation->duration)->isSameMinute($start)) {
      return true;
    }
    return false;
  }
}
