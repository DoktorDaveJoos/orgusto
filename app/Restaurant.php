<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Restaurant extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'table_count',
        'contact_email',
        'owner',
        'street',
        'zip_code',
        'street_number',
        'city',
        'default_table_seats',
        'seat_reservation_bound'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['role']);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
