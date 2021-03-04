<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_NO_CONTENT = 204;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_INTERNAL_SERVER_ERROR = 500;

    public function getRestaurant()
    {
        return auth()->user()->selected;
    }

    protected function getStartFromRequest(Request $request): CarbonImmutable
    {
        $from = Carbon::today()->toISOString();
        if ($request->has('from')) {
            $from = $request->get('from');
        } elseif ($request->has('date')) {
            $from = $request->get('date');
        }

        return CarbonImmutable::parse($from)->setTime(0, 0);
    }

    protected function getEndFromRequest(Request $request): CarbonImmutable
    {
        $to = Carbon::today()->toISOString();
        if ($request->has('to')) {
            $to = $request->get('to');
        } elseif ($request->has('date')) {
            $to = $request->get('date');
        }

        return CarbonImmutable::parse($to)->setTime(23, 59);
    }
}
