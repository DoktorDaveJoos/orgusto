<?php

namespace App\Http\Controllers;

use App\Nova\Reservation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userData = Auth::user()->load(['restaurants.tables']);
        dd($userData->toArray());
        return view('manage', ['userData' => Auth::user()->load(['restaurants.tables'])]);
    }
}
