<?php

namespace App\Http\Middleware\Lumen;

use App\Model\mstTransactionList;
use Closure;

class transConfirmHanddlerMiddleware
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
        try {
            $obj = mstTransactionList::findOrFail($request->q);
            $obj3 = $obj->getMethod;
            $obj2 = $obj3 ? $obj3->method : null;
        } catch (\Exception $e) {
            return response()->json(['msg' => 'data tidak terdaftar'], 404);
        }


        if ($obj->status === 'konfirmasi' && now()->lt($obj->updated_at->addDays(1))) {
            if ($obj2 === 'Transfer' || $obj2 === 'Bayar Ditempat') {
                $request->request->add([
                    'met' => $obj3 ? $obj3->id : null
                ]);
            } else {
                return response()->json(['msg' => 'data tidak terdaftar'], 404);
            }
        } else {
            return response()->json(['msg' => 'data tidak terdaftar'], 404);
        }
        return $next($request);
    }
}
