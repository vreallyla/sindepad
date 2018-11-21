<?php

namespace App\Http\Middleware;

use Closure;
use App\DeclaredPDO\Jwt\jwtClass;

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

//            $request->request->add(['anu' => $ab]);
        } catch (\Exception $e) {
            if ($this->checkCookie()) {
                $this->remove_cookie();
            }

            $request->request->add([
                'data' => false
            ]);

            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan login lagi');
        }

        if (!$check) {
            $request->request->add([
                'data' => $this->refreshWithCookie() ? $this->refreshWithCookie() : false
            ]);
        }
        if ($request->has('token')) {
            $request->offsetUnset('token');
        }


        return $next($request);
    }

}
