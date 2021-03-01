<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spark\Billable;

class Restaurant extends Model
{
    use Billable, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'table_count',
        'contact_email',
        'owner_id',
        'default_table_seats',
        'seat_reservation_bound'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['role']);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
