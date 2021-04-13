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
    return auth()
      ->user()
      ->restaurants()
      ->first()
      ->users()
      ->get()
      ->toJSON();
  }
}
