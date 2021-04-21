<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user());
    }

    public function users()
    {
        $users = $this->getRestaurant()->users()->get();
        return UserResource::collection($users);
    }
}
