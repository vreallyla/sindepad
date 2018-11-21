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
        $checkCookie = self::checkCookie();

        try {
            $check = $checkCookie ? $request->request->add(['token' => self::get_cookie()->token]) : true;

//            $request->request->add(['anu' => $ab]);
        } catch (\Exception $e) {
            $checkCookie ? $this->remove_cookie() : false;

            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan masuk lagi');
        }

        if ($check || !$data = $this->refreshWithCookie()) {
            $checkCookie ? $this->remove_cookie() : false;

            return redirect()->route('welcome')->with('msg', 'silakan masuk terlebih dahulu');
        }

        $request->request->add([
            'data' => $data
        ]);

        return $next($request);
    }
}
