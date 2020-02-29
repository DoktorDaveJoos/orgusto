<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Restaurant extends Model
{

    use Notifiable;

    protected $fillable = [
        'name', 'table_count', 'contact_email', 'owner', 'street', 'zip_code', 'street_number', 'city'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function users() {
        return $this->belongsToMany(User::class)->withPivot(['role']);;
    }

    public function tables() {
        return $this->hasMany(Table::class);
    }

}
