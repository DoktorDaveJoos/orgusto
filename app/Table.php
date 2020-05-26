<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'seats', 'table_number', 'description'
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
        return $this->reservations()->whereBetween('starting_at', [$from, $to]);
    }
}
