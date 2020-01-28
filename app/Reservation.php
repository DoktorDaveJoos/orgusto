<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'notice', 'person_count', 'starting_at', 'length', 'accepted_from', 'user_id'
    ];

    protected $casts = [
        'starting_at', 'created_at'
    ];

    public function scopeClosest($query)
    {
        return $query->orderBy('starting_at', 'asc');
    }
}
