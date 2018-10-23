<?php

namespace App\Http\Controllers\Api\User;

use App\DeclaredPDO\Additional\plugClass;
use App\Model\rsUserToStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class kidController extends Controller
{
    use plugClass;


    public function get_kid(Request $r)
    {
        foreach (rsUserToStudent::where('user_id',$r->code)->orderBy('created_at','asc')->get() as $row){
            $data[]=$row->getStudent;
        }
        return $data;
    }
}
