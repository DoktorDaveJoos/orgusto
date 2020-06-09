<?php

namespace App\Http\Livewire;

use App\Reservation;
use Livewire\Component;

class SearchReservation extends Component
{

    public $searchTerm;
    public $results;

    public function render()
    {

        if (strlen($this->searchTerm) > 0) {
            $this->results = Reservation::search($this->searchTerm)->get();
        } else {
            $this->results = [];
        }

        return view('livewire.search-reservation');
    }
}
