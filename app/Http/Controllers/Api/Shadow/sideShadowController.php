<?php

namespace App\Http\Controllers\Api\Shadow;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserTeacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class sideShadowController extends Controller
{

    use extraClass;

    public function changePhoto(Request $r)
    {
        $re = $r->only('img');
        $rule = [
            'img' => 'required|image|max:6000',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'image' => 'harap Menggunakan',
            'max' => 'harap ukuran tidak  melebihi 6mb'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $new = $r->file('img');
        $data = $this->getId();

        if ($new->isValid()) {
            if ($this->conditionImg($data->url)) {
                Storage::delete('public/' . self::slice_storage($data->url));
            }

            $name = Storage::disk('local')->put('public/users/photo', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;

            $img = Image::make($thumbnailpath)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 100)->save($thumbnailpath);

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }


            $data->update(
                [
                    'url' => $url
                ]
            );

            return $this->noticEditPlusData([
                'img' => $this->checkImg($url)
            ]);
        }

        return $this->noticeFail();
    }

    public function updateProfile(Request $r)
    {

        $re = $r->only('born_place', 'address', 'dob', 'email', 'last_edu', 'name', 'phone', 'rel', 'sex');
        $rule = [
            'born_place' => 'required',
            'address' => 'required',
            'dob' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->getId()->email,
            'name' => 'required',
            'phone' => 'required',
            'sex' => 'required|exists:side_genders,id',
            'rel' => 'required|exists:side_marital_statuses,id',
            'last_edu' => 'required|exists:side_last_educations,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada',
            'email'=>'Gunakan format email',
            'unique'=>'email telah digunakan'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }


        try {
            $user = $this->getId();

            if ($user->getTeacher) {
                $user->getTeacher()->update([
                    'register' => Carbon::parse($this->getId()->created_at)->toDateString(),
                    'education_id' => $r->last_edu,
                    'marital_id' => $r->rel
                ]);
            } else {
                linkUserTeacher::create([
                    'register' => Carbon::parse($this->getId()->created_at)->toDateString(),
                    'education_id' => $r->last_edu,
                    'marital_id' => $r->rel,
                    'user_id' => $this->getId()->id
                ]);
            }

            $user->update(array_merge(
                $r->only('born_place', 'address', 'email', 'name', 'phone'),
                [
                    'gender_id' => $r->sex,
                    'dob' => Carbon::createFromFormat('d/m/Y', $r->dob)->toDateString()
                ]

            ));
        } catch (\Exception $r) {
            return $this->noticeFail();
        }

        return response()->json(['data' => $r->only('born_place', 'address', 'email', 'name', 'phone'), 'msg' => 'Berhasil dirubah']);
    }

    public function updatePass(Request $r)
    {
        $re = $r->only('new_pass', 'old_pass');
        $rule = [
            'new_pass' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            'old_pass' => 'required'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'regex' => 'Harap melakukan kombinasi huruf, angka, dan simbol',
            'min' => 'minimal 6 huruf'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $user = $this->getId();

        if (Hash::check($r->old_pass, $user->password)) {
            $user->update([
                'password' => bcrypt($r->new_pass)
            ]);
        } else {
            return response()->json(['old_pass' => 'Kata sandi lama salah'], 422);
        }
        return $this->noticeEditSuc();

    }
}
