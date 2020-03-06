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

    public function byDate($date)
    {


        $tables = Auth::user()->restaurants()->first()->tables()->with(['reservations' => function ($query) {
            $query->whereBetween('starting_at', [date('2020-01-01'), date('2020-02-26 18:00:00')]);
        }])->get();



        dd($tables->toArray());
        return view('manage', ['tables' => Auth::user()->restaurants->first()->tables()->sortByTableNumber()->reservations->whereBetween('starting_at', [$from, $to])->get()]);
    }
}
