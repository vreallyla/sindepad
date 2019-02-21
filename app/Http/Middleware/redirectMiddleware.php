<?php

namespace App\Http\Middleware;

use App\DeclaredPDO\Jwt\jwtClass;
use Closure;

class redirectMiddleware
{

    use jwtClass;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($r, Closure $next)
    {
        $user = $this->get_id();
        $check = $user->getStatus ? $this->get_id()->getStatus->ind : '';
        if ($check === 'Admin') {
            return redirect()->route('admin.index');
        } elseif ($check === 'Pengajar') {
            return redirect()->route('shadow.index');
        } elseif ($check === 'User') {
            if ($user->ni){
            return redirect()->route('user.in.home');}
            else{
                return redirect()->back();
            }
        } else {
            return abort(404);
        }
    }
}
