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

    public function scoped($date, $scopedHour)
    {

        $from = date($date." 00:00:00");
        $to = date($date." 23:59:59");

        $tables = Auth::user()->restaurants()->first()->tables()->with(['reservations' => function ($query) use($from, $to) {
            $query->whereBetween('starting_at', [$from, $to]);
        }])->sortByTableNumber()->get();

        return view('manage', ['tables' => $tables, 'date' => $date, 'scopedHour' => $scopedHour]);
    
    }
}
