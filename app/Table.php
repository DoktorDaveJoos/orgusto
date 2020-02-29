<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'seats',
    ];

    public function scopeSortByTableNumber($query) {
        return $query->orderBy('table_number', 'asc');
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations() {
        return $this->belongsToMany(Reservation::class);
    }
}
