<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class jwtMiddleware
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
        \Tymon\JWTAuth\JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
