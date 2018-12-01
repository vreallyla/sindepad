<?php

namespace App\Http\Controllers\Api\Admin\master;

use App\DeclaredPDO\Admin\Master\users;
use App\DeclaredPDO\Jwt\extraClass;
use App\Mail\noticeNewUserMail;
use App\User;
use App\verifyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

const TYPE_USER = ['Admin', 'Pengajar', 'User', 'Peserta Didik', 'Hub'];

class userListController extends Controller
{

    use extraClass;

    public function getList(Request $r)
    {
        if ($err = $this->valid($r)) {
            return $err;
        }
        $user = new users($r);
        if ($r->cat !== TYPE_USER[3]) {
            $get = $user->getUsers();
        } else {
            $get = $user->getStudents();
        }


        return $this->setPaginate(($r->q ? users::searchSome($get, $r->q) : $get), $r->row, $r->page);
    }


    public function create(Request $r)
    {
        $re = $r->only('name', 'email', 'gender', 'role');
        $rule = [
            'role' => 'required|in:Pengajar,Admin',
            'name' => 'required|min:3',
            'gender' => 'required|exists:side_genders,id',
            'email' => 'required|string|email|max:255|unique:users',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'exist' => 'Harap tidak merubah data',
            'unique' => 'email sudah dipakai',
            'name.min' => 'isi minimal 3 huruf',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $pass = str_random(12);

        if (!$status = $this->getUserStatus($r->role)) {
            return $this->noticechangeData();
        }

        $user = User::create([
            'name' => $r->name,
            'gender_id' => $r->gender,
            'email' => $r->email,
            'password' => bcrypt($pass),
            'code_status' => bcrypt(false),
            'status_id' => $status,
            'url' => 'images/img_unvailable.png',
            'ni' => $this->niSet(new User(), ($r->role === 'Pengajar' ? 2 : 1))

        ]);
        $verify = verifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(45)
        ]);

        try {
            Mail::to($r->email)->send(new noticeNewUserMail([
                'role' => $r->role,
                'password' => $pass,
                'email' => $r->email,
                'name' => $r->name,
                'code' => $verify->token
            ]));
        } catch (\Exception $e) {
            verifyUser::find($verify->id)->delete();
            User::find($user->id)->forceDelete();
            return $this->noticeFail();
        }

        return response()->json(['msg' => 'Berhasil dibuat.']);
    }

    private function valid($model)
    {

        $re = $model->only('cat', 'page', 'row');
        $rule = [
            'cat' => 'required|in:Admin,Pengajar,User,Peserta Didik',
            'page' => 'required|numeric',
            'row' => 'required|in:9,27,45'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    public function user_detail(Request $r)
    {

        $re = $r->only('key', 'cat');
        $rule = [
            'cat' => 'required|in:Admin,Pengajar,User,Peserta Didik,Hub',
            'key' => 'required|' . ($r->cat == TYPE_USER[3] ? 'exists:link_user_students,id' :
                    ($r->cat == TYPE_USER[4] ? 'exists:rs_student_families,id' : 'exists:users,id')),
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $users = new users($r);
        return $users->getspes();
    }
}
