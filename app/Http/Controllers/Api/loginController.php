<?php

namespace App\Http\Controllers\Api;

use App\trGender;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    public function checkEmail(Request $r)
    {
//        dd($r->email);

//            $result = DB::select('select email from users where email = ?', [$r->email]);
//        $match= app('db')->select("SELECT email FROM users WHERE email='$r->email'");
//return trGender::all();
        return $this->matchEmail($r->email);
    }

    private function matchEmail($e)
    {
       $match= DB::select('select email from users where email = ?', [$e]);

        if (!empty($match)){
            return 'true';
        }

    }

    public function anu()
    {
        return 'anu';
    }
}
