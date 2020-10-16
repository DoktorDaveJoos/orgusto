<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    CONST STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_NO_CONTENT = 204;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_INTERNAL_SERVER_ERROR = 500;

    public function getRestaurant(): Restaurant {
        return auth()->user()->firstRestaurant();
    }
}
