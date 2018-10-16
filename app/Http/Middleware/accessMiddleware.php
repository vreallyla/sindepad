<?php

namespace App\Http\Middleware;

use Closure;
use App\DeclaredPDO\jwtClass;
use Illuminate\Support\Facades\Cookie;

class accessMiddleware
{
    use jwtClass;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $check = self::checkCookie() ? $request->request->add(['token' => self::get_cookie()->token]) : true;
            if (!$check) {
                $this->refreshWithCookie();
            }
            if ($request->has('token')) {
                $request->offsetUnset('token');
            }
//            $request->request->add(['anu' => $ab]);
        } catch (\Exception $e) {
            if ($this->checkCookie()) {
                $this->remove_cookie($this->get_cookie(),59);
            }


            return $e;
        }


        return $next($request);
    }

}
