<?php

namespace App\Http\Middleware;

use App\Libraries\Famous\Authentification\Auth;
use Closure;

class AuthRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! Auth::getUserId()) {
            return redirect()->route('auth.login', ['redirect' => $request->getUri()]);
        }
        return $next($request);
    }
}
