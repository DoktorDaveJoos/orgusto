<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Reservation extends Model
{
    use HasFactory;
    use Notifiable;
    use Searchable;
    use SoftDeletes;

    public $asYouType = true;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only(
            'id',
            'name',
            'notice',
            'persons',
            'start',
            'duration',
            'email',
            'phone_number',
            'user_id'
        );
    }

    protected $fillable = [
        'name',
        'notice',
        'persons',
        'start',
        'duration',
        'color',
        'email',
        'phone_number',
        'user_id',
        'done'
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

    public function getHumanReadableTime()
    {
        return $this->start->format('H:i');
    }

    public function scopeClosest($query)
    {
        return $query->orderBy('start', 'asc');
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
