<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\User;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    public function index()
    {

        $restaurants = auth()->user()->restaurants()->get();

        return view('restaurants', ['restaurants' => $restaurants]);
    }

    public function show(Restaurant $restaurant)
    {
        return $restaurant;
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        // PATCH /restaurants/1
        return "full lord";
    }

    public function store(Request $request)
    {
        dd(auth()->user()->access_level);
        return "gaylord";
    }
}
