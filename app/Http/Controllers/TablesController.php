<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailableTables;
use App\Http\Resources\TableResource;
use App\Reservation;
use Carbon\CarbonImmutable;

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

  public function index(GetAvailableTables $request)
  {
    $start_date = CarbonImmutable::createFromDate($request->get('start'));

    $end_date = $start_date->addMinutes($request->get('m'));

    $restaurant = $this->getRestaurant();

    $r_id = $request->get('r_id');
    $reservation = Reservation::find($r_id);
    if ($reservation) {
      $bookedTables = $reservation->tables;
      $freeTables = $restaurant
        ->tables()
        ->availableBetween($start_date, $end_date)
        ->get();
      return $bookedTables->concat($freeTables)->unique();
    }

    return $restaurant
      ->tables()
      ->availableBetween($start_date, $end_date)
      ->get();
  }

  public function allTables()
  {
    return TableResource::collection($this->getRestaurant()->tables);
  }
}
