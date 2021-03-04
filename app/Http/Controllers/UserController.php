<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function show(User $user) {
        return view('edit-user', ['user' => $user]);
    }

    public function user(Request $request) {
        $user = auth()->user();
        return $user;
    }

    public function users()
    {
        return auth()->user()->restaurants()->first()->users()->get()->toJSON();
    }
}
