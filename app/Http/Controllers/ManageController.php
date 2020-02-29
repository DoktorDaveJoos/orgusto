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
        $userData = User::with(['reservations', 'restaurants'])->find(Auth::user()->id);
        // dd($userData->reservations->toArray());
        return view('manage', ['userData' => $userData]);
    }
}
