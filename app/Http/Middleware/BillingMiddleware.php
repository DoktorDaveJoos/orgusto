<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BillingMiddleware
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
    if ($request->user() && $request->user()->selected && !$request->user()->selected->subscribed()) {
      $request
        ->session()
        ->flash(
          'message',
          'Das ist erst möglich wenn Du für dein Restauraunt: \'' .
            auth()->user()->selected->name .
            '\' ein Abo-Plan gewählt hast.'
        );
      return redirect()->route('spa');
    }

    return $next($request);
  }
}
