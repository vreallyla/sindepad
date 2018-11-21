<?php

namespace App\Http\Middleware;


use App\DeclaredPDO\Jwt\jwtClass;
use App\Model\mstTransactionList;
use Closure;

class validUserMiddleware
{
    use jwtClass;

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

        if (!$check) {
            if ($this->getId() && $this->getId()->id !== mstTransactionList::findOrFail($request->q)->user_id) {
                return abort('404');
            }
        } else {
            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan masuk lagi');
        }

        return $next($request);
    }
}
