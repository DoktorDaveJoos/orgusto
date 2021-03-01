<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show landing page.
     */
    public function show()
    {

        if (auth()->user()) {
            return redirect()->route('reservations.show');
        }

        return view('home');
    }
}
