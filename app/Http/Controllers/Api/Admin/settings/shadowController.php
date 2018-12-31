<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Admin\Master\users;
use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\Model\rsHomeroom;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class shadowController extends Controller
{

    use extraClass;

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'page', 'row');
        $rule = [
            'cat' => 'required|in:Sudah Diatur,Belum Diatur',
            'page' => 'required|numeric',
            'row' => 'required|in:10,30,50'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $user = new users($r);
        $get = $user->getShadow();

        return $this->setPaginate(($r->q ? users::searchSome($get, $r->q) : $get), $r->row, $r->page);
    }

    public function getNotif()
    {
        $r=self::convertToObject(['cat'=>'Belum Diatur']);

        $user = new users($r);
        $arr['list']=$get = $user->getShadow();
        $arr['quantity']=count($get);
        $arr['notice']=count($get)>0?true:null;

        return response()->json($arr);
    }

    public function change(Request $r)
    {
        $re = $r->only('key_shadow', 'key_student');
        $rule = [
            'key_shadow' => 'required|exists:users,id',
            'key_student' => 'required|exists:link_user_students,id'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $shadow = User::find($r->key_shadow);
        $student = linkUserStudent::find($r->key_student);

        if ($shadow->getStatus->ind !== 'Pengajar') {
            return response()->json(['key_shadow' => 'Harap tidak merubah data'], 422);
        }

       if (!$student->getShadow->isEmpty()){
           foreach ($student->getShadow as $row) {
               if ($row->teacher_id !== $r->key_shadow) {
                   $row->update([
                       'teacher_id' => $r->key_shadow
                   ]);
                   return $this->noticeSuc();

               } else {
                   return response()->json(['msg' => 'data tidak berubah']);
               }
           }
       }else{
           rsHomeroom::create([
              'teacher_id'=>$r->key_shadow,
               'student_id'=>$student->id
           ]);
           return $this->noticeSuc();
       }
    }
}
