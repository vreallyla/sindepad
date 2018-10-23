<?php

namespace App\Http\Middleware\Role;

use App\DeclaredPDO\Jwt\jwtClass;
use Closure;

class justInController
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
                $this->remove_cookie($this->get_cookie(), 59);
            }

            $request->request->add([
                'data' => false
            ]);

            return redirect()->route('welcome')->with('msg','terdapat kesalahan, silakan masuk lagi');
        }

        if ($check) {
            return redirect()->route('welcome')->with('msg','silakan masuk terlebih dahulu');
        }

        $request->request->add([
            'data' => $this->refreshWithCookie() ? $this->refreshWithCookie() : false
        ]);

        if ($request->has('token')) {
            $request->offsetUnset('token');
        }
        return $next($request);
    }
}
