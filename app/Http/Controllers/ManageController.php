<?php

namespace App\Http\Controllers;

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
        return view('manage', ['tables' => Auth::user()->restaurants->first()->tables()->sortByTableNumber()->with('reservations')->get()]);
    }
}
