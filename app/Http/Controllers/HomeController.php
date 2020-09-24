<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show landing page.
     *
     * @return Renderable
     */
    public function index()
    {
        $someValue = "foo";

        return view('home');
    }
}
