<?php

namespace App\Http\Livewire;

use App\Restaurant;
use Livewire\Component;

class EditRestaurant extends Component
{
    public $restaurant_id;
    public $name;
    public $contact_email;
    public $owner;
    public $street;
    public $street_number;
    public $zip_code;
    public $city;
    public $updated_at;
    public $tables;

    protected $casts = [
        'updated_at' => 'date'
    ];

    public function getUpdatedAtForHumans()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    public function mount($restaurant)
    {
        $restaurant = Restaurant::find($restaurant);
        $this->restaurant_id = $restaurant->id;
        $this->name = $restaurant->name;
        $this->contact_email = $restaurant->contact_email;
        $this->owner = $restaurant->owner;
        $this->street = $restaurant->street;
        $this->street_number = $restaurant->street_number;
        $this->zip_code = $restaurant->zip_code;
        $this->city = $restaurant->city;
        $this->updated_at = $restaurant->updated_at;
        $this->tables = $restaurant->tables()->get();
    }

    public function render()
    {
        return view('livewire.edit-restaurant');
    }
}
