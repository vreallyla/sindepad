<?php

namespace App\Http\Middleware\Role;

use App\DeclaredPDO\Jwt\jwtClass;
use App\Model\rsUserToStudent;
use Closure;

class UserMiddleware
{

    use jwtClass;

    protected $data;
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

        } catch (\Exception $e) {

            if ($this->checkCookie()) {
                $this->remove_cookie($this->get_cookie(), 59);
            }

            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan login terlebih dahulu');

        }
        if (!$check) {
            $this->data= $this->refreshWithCookie();
            $userLabel=$this->guard()->user();
            $status= self::convertToObject($userLabel->only('email','ni','gender_id','phone','address','religion','born_place','dob','created_at','name'));

            $child= rsUserToStudent::where('user_id',$userLabel->id)->get();

                foreach ($child as $row){
                    $kid[]=self::convertToObject($row->getStudent->only('name','class_id'));
                }

        }
        if (empty($this->data)) {
            return redirect()->route('welcome')->with('msg', 'silakan login terlebih dahulu');
        }

        $request->request->add([
            'data' => $this->data,
            'more'=> $status,
            'kids'=>$kid

        ]);

//        if ($request->has('token')) {
//            $request->offsetUnset('token');
//        }
        return $next($request);
    }

}
