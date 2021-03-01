<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BillingMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = $request->user();

        if ($user && !$user->firstRestaurant()->owner())

        return $next($request);
    }
}
