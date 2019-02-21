<?php

namespace App\Http\Controllers\Api\User\In;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\Model\sideDaylist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class userScheController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        if ($er = $this->valScheId($r)) {
            return $er;
        }
        $sche =linkUserStudent::find($r->key)->getSche;
       if ($sche) {
           $day = sideDaylist::orderBy('created_at', 'asc')->get();
           $arr = [];

           foreach ($day as $row) {
               $arr[] = [
                   'name' => $row->ind,
                   'key' => $row->id,
                   'list' => $this->dayList($row, $sche->id)

               ];
           }

           return response()->json($arr);
       } else {
           return response()->json(['msg' => 'jadwal belum diatur'], 403);
       }
    }

    private function valScheId($r)
    {
        $re = $r->only('key');
        $rule['key'] = 'required|exists:link_user_students,id';

        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'Harap tidak merubah data'
        ];


        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }
}
