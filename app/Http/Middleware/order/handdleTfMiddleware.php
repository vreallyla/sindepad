<?php

namespace App\Http\Middleware\order;

use App\Model\mstTransactionList;
use Carbon\Carbon;
use Closure;

class handdleTfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $obj = mstTransactionList::findOrFail($request->q);
        $obj3 = $obj->getMethod;
        $obj2 = $obj3 ? $obj3->method : null;
        $date = $obj->updated_at->addDays(1);

        if ($obj->status === 'konfirmasi' && now()->lt($date)){
            if ($obj2 === 'Transfer' || $obj2 === 'Bayar Ditempat') {
                $request->request->add([
                    'met' => $obj3 ? $obj3->id : null
                ]);
            } else {
                return abort(404);
            }
    } else {
        return abort(404);
    }


        return $next($request);
    }
}
