<?php

namespace App\Http\Middleware\Lumen;

use App\Model\mstTransactionList;
use Closure;

class transConfTransMiddleware
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
        foreach ($request->trans as $row) {
            try {
                $obj = mstTransactionList::findOrFail($row);
            } catch (\Exception $e) {
                return response()->json(['msg' => 'data tidak terdaftar'], 404);
            }
            if ($obj->status === 'menunggu' && now()->lt($obj->updated_at->addDays(1))) {

            } else {
                return response()->json(['msg' => 'data tidak terdaftar'], 404);
            }
        }
        return $next($request);
    }
}
