<?php

namespace App\Http\Middleware\Lumen\Role;

use App\DeclaredPDO\Jwt\jwtClass;
use Closure;

class adminMiddleware
{
    use jwtClass;

    public function handle($request, Closure $next)
    {
        try {
            $id = $this->get_id();

        } catch (\Exception $e) {
            return response()->json(['msg' => $e], 403);
        }

        if (!$id) {
            return response()->json(['error' => 'terdapat kesalahan, harap muat ulang halaman'], 401);
        }
        elseif ($id->getStatus->ind!=='Admin'){
            return response()->json(['error' => 'Kamu tidak memiliki akses.'], 401);
        }


        return $next($request);
    }
}
