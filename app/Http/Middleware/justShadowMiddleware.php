<?php

namespace App\Http\Middleware;

use App\DeclaredPDO\Jwt\jwtClass;
use Closure;

class justShadowMiddleware
{
    use jwtClass;

    public function handle($request, Closure $next)
    {
        try {
            $id = $this->get_id();

        } catch (\Exception $e) {
            return abort(403);
        }

        if (!$id) {
            return abort(401);
        }
        elseif ($id->getStatus->ind!=='Pengajar'){
            return abort(401);
        }

        return $next($request);
    }
}
