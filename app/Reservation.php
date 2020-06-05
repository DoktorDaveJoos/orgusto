<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id', 'name', 'notice', 'person_count', 'starting_at', 'length', 'accepted_from', 'color', 'email', 'phone_number', 'table_id'
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

    public function getHumanReadableDate()
    {
        $today = Carbon::now();
        $today->setTime(0, 0, 0); // reset time part, to prevent partial comparison
        $diff = $this->starting_at->diff($today)->days;
        if ($diff == 0) {
            return "today";
        } else if ($diff == 1) {
            return "tomorrow";
        } else if ($diff == -1) {
            return "yesterday";
        } else {
            return $this->starting_at->format("D d.m, H:i") . " Uhr";
        }
    }

    public function scopeClosest($query)
    {
        return $query->orderBy('starting_at', 'desc');
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
