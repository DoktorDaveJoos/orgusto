<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
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

    public function scopeAvailableBetween($query, $from, $to)
    {
        return $query->whereDoesntHave('reservations', function ($q) use ($from, $to) {
            $q->whereBetween('start', [$from, $to])->orWhereBetween('end', [$from, $to]);
        });
    }

    public function scopeWithEnoughSeats($query, $persons)
    {
        return $query->where('seats', '>=', $persons);
    }
}
