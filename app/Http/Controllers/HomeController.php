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
        return view('home');
    }
}
