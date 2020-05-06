<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'notice', 'person_count', 'starting_at', 'length', 'accepted_from', 'color', 'email', 'phone_number', 'table_id'
    ];

    protected $casts = [
        'starting_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['starting_at'];

    public function scopeClosest($query)
    {
        return $query->orderBy('starting_at', 'desc');
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }
}
