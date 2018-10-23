<?php

namespace App\Http\Middleware\Lumen\Role;

use App\DeclaredPDO\Jwt\jwtClass;
use Closure;
//use App\DeclaredPDO\Jwt\lumen\apiJWTClass;

class userMiddleware
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
            $id = $this->get_id();

        } catch (\Exception $e) {
            return response()->json(['msg' => $e], 422);
        }

        if (!$id) {
            return response()->json(['msg' => 'something wrong,check your connection and refresh page'], 422);
        }

        $request->request->add(['code' => $id->id]);

        return $next($request);
    }
}
