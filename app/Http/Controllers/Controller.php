<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
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

    protected function getStartFromRequest(Request $request): CarbonImmutable {
        $from = date('Y-m-d');
        if ($request->has('from')) {
            $from = $request->get('from');
        } elseif ($request->has('date')) {
            $from = $request->get('date');
        }

        return CarbonImmutable::createFromDate(date($from . "00:00:00"));
    }

    protected function getEndFromRequest(Request $request): CarbonImmutable {
        $to = date('Y-m-d');
        if ($request->has('to')) {
            $to = $request->get('to');
        } elseif ($request->has('date')) {
            $to = $request->get('date');
        }

        return CarbonImmutable::createFromDate(date($to . "23:59:59"));
    }
}
