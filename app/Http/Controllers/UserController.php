<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{

    public function show(User $user) {
        return view('edit-user', ['user' => $user]);
    }

    public function users()
    {
        return auth()->user()->restaurants()->first()->users()->get()->toJSON();
    }
}
