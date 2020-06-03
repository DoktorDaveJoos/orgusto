<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function validated()
    {
        return $this->email_verified_at < date("Y-m-d H:i:s");
    }

    public function isPremium()
    {
        return $this->access_level === 'premium';
    }
}
