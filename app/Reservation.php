<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Reservation extends Model
{
    use HasFactory;
    use Notifiable;
    use Searchable;

    public $asYouType = true;

    protected $fillable = [
        'name',
        'notice',
        'persons',
        'start',
        'duration',
        'color',
        'email',
        'phone_number',
        'user_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only('id', 'name', 'notice', 'email', 'phone_number');
    }


    public function getHumanReadableDate()
    {

        if ($this->start->isToday()) {
            return "Today";
        }

        if ($this->start->isTomorrow()) {
            return "Tomorrow";
        }

        if ($this->start->isYesterday()) {
            return "Yesterday";
        }

        return $this->start->format("d.m");

    }

    public function getHumanReadableTime()
    {
        return $this->start->format('H:i');
    }

    public function scopeClosest($query)
    {
        return $query->orderBy('start', 'desc');
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
