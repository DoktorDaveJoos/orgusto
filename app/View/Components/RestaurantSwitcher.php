<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RestaurantSwitcher extends Component
{

    public $restaurants;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->restaurants = auth()->user()->restaurants;
        $this->selected = auth()->user()->selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.restaurant-switcher');
    }
}
