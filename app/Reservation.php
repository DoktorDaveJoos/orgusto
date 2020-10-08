<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Psy\Util\Json;

class Reservation extends Model
{
    use HasFactory;
    use Notifiable;
    use Searchable;

    public $asYouType = true;

    protected $fillable = [
        'user_id',
        'name',
        'notice',
        'persons',
        'start',
        'duration',
        'accepted_from',
        'color',
        'email',
        'phone_number',
        'table_id'
    ];

    protected $casts = [
        'duration' => Json::class,
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
        return $this->only('name', 'notice', 'email', 'phone_number');
    }


    public function getHumanReadableDate()
    {
        $today = Carbon::now();
        $today->setTime(0, 0, 0); // reset time part, to prevent partial comparison
        $diff = $this->start->diff($today)->days;
        if ($diff == 0) {
            return "today";
        } else if ($diff == 1) {
            return "tomorrow";
        } else if ($diff == -1) {
            return "yesterday";
        } else {
            return $this->start->format("D d.m, H:i") . " Uhr";
        }
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
