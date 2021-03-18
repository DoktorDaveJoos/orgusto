<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'type'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)->withPivot(['role']);
    }

    public function selected()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function firstRestaurant()
    {
        return $this->restaurants()->first();
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function validated()
    {
        return $this->email_verified_at < date('Y-m-d H:i:s');
    }
}
