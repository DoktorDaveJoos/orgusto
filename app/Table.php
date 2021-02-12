<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Table extends Model
{

    use HasFactory;

    protected $fillable = [
        'seats', 'table_number', 'description', 'room'
    ];

    public function scopeSortByTableNumber($query)
    {
        return $query->orderBy('table_number', 'asc');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function reservationsBetween($from, $to)
    {
        return $this->reservations()->whereBetween('start', [$from, $to]);
    }

    /**
     * Returns a {@code QueryBuilder} which contains only a collection of {@code Table} which do not
     * have a {@code Reservation} somehow overlapping with the given timeframe (from -> to).
     *
     * @param $query - Auto injected.
     * @param $from - A {@code Date} where timeframe begins.
     * @param $to - A {@code Date} where timeframe ends.
     * @return mixed - {@code QueryBuilder}
     */
    public function scopeAvailableBetween($query, $from, $to)
    {
        $from = Carbon::parse($from)->addMinute();
        $to = Carbon::parse($to)->subMinute();
        return $query
            ->whereDoesntHave('reservations', function ($q) use ($from, $to) {
                $q->whereBetween('start', [$from, $to])
                    ->orWhereBetween(DB::raw('DATE_ADD(start, INTERVAL duration MINUTE)'), [$from, $to]);
            })->whereDoesntHave('reservations', function ($q) use ($from, $to) {
                $q->where('start', '<=', $from)->where(DB::raw('DATE_ADD(start, INTERVAL duration MINUTE)'), '>=', $to);
            });
    }

    public function scopeWithReservationsBetween($query, $from, $to)
    {
        return $query
            ->whereHas('reservations', function ($q) use ($from, $to) {
                $q->whereBetween('start', [$from, $to])
                    ->orWhereBetween(DB::raw('DATE_ADD(start, INTERVAL duration MINUTE)'), [$from, $to]);

            })->orWhereHas('reservations', function ($q) use ($from, $to) {
                $q->where('start', '<=', $from)->where(DB::raw('DATE_ADD(start, INTERVAL duration MINUTE)'), '>=', $to);

            })->with(["reservations" => function($query) use ($from, $to) {
                $query->whereBetween('start', [$from, $to])
                    ->orWhereBetween(DB::raw('DATE_ADD(start, INTERVAL duration MINUTE)'), [$from, $to]);
            }]);
    }

    public function scopeWithEnoughSeats($query, $persons)
    {
        return $query->where('seats', '>=', $persons);
    }
}
