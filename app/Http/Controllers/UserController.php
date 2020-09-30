<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class UserController extends Controller
{



    public function users()
    {
        return auth()->user()->restaurants()->first()->users()->get()->toJSON();
    }
}
