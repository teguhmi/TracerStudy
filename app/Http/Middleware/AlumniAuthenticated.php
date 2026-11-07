<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlumniAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
  public function handle(Request $request, Closure $next)
  {
    if (
      session('login_type') !== 'alumni' ||
      !session('alumni_authenticated') ||
      !session()->has('nim')
    ) {
      return redirect()
        ->route('login-alumni')
        ->with('error', 'Silakan login terlebih dahulu.');
    }

    return $next($request);
  }
}
