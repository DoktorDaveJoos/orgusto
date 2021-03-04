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

        if ($request->user() && !$request->user()->selected->subscribed()) {
            $request->session()->flash('message', 'Du musst dich erst für einen Plan entscheiden :-)');
            return redirect()->route('restaurants.show');
        }

        return $next($request);
    }
}
