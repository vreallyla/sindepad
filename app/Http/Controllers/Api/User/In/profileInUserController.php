<?php

namespace App\Http\Controllers\Api\User\In;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\Model\mstDisability;
use App\Model\rsDisability;
use App\rsStudentFamily;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class profileInUserController extends Controller
{

    use extraClass;

    public function kids()
    {
        return response()->json(User::getStudentN($this->getId()));
    }

    public function kidDetail(Request $r)
    {
        if ($er = $this->valKidKey($r)) {
            return $er;
        }

        $check = linkUserStudent::Chekparent($r->key, $this->getId()->id);
        if ($check->isEmpty()) {
            return $this->noticeAccess();
        }
        $data = linkUserStudent::detailN($r->key);
        $data['rel'] = array_merge($data['rel'], ['selected' => $check[0]->hub_id]);

        return $data;
    }

    public function editKid(Request $r)
    {
        $re = $r->only('name', 'gender', 'born_place', 'dob', 'rel', 'needed', 'address', 'key');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
            'name' => 'required|min:3|max:32',
            'gender' => 'required|exists:side_genders,id',
            'born_place' => 'required',
            'dob' => 'required|date_format:d/m/Y',
            'rel' => 'required|exists:mst_hubs,id',
            'needed' => 'required|array|exists:mst_disabilities,id',
            'address' => 'required',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada',
            'date_format' => 'Gunakan format ' . now()->toDateString(),
            'array' => 'Gunakan format data array',
            'name.min' => 'Masukkan Nama minim 3 huruf',
            'name.max' => 'Masukkan Nama maks 3 huruf'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $check = linkUserStudent::Chekparent($r->key, $this->getId()->id);
        if ($check->isEmpty()) {
            return $this->noticeAccess();
        }

        $student = linkUserStudent::find($r->key);

        $student->getDisablity()->delete();

        $student->getFams()->where('user_id',$this->getId()->id)->first()->update([
           'hub_id'=>$r->rel
        ]);

        foreach ($r->needed as $row){
            rsDisability::create([
                'student_id'=>$r->key,
                'disablity_id'=>$row
            ]);
        }

        $student->update([
            'name' => $r->name,
            'gender_id' => $r->gender,
            'born_place' => $r->born_place,
            'dob' => Carbon::createFromFormat('d/m/Y',$r->dob)->toDateString(),
            'address' => $r->address,
        ]);

        return $this->noticeEditSuc();
    }

    public function changePhotoKid(Request $r)
    {
        if ($er = $this->valKidKey($r)) {
            return $er;
        }

        $new = $r->file('img');
        $data = linkUserStudent::find($r->key);

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

    private function valKidKey($r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    public function editProfile(Request $r)
    {

        $re = $r->only('born_place', 'address', 'dob', 'email', 'last_edu', 'name', 'phone', 'profession', 'sex');
        $rule = [
            'born_place' => 'required',
            'address' => 'required',
            'dob' => 'required',
            'email' => 'required|email|max:128|unique:users,email,' . $this->getId()->id . ",id",
            'name' => 'required',
            'phone' => 'required',
            'sex' => 'required|exists:side_genders,id',
            'profession' => 'required|exists:side_profession_lists,id',
            'last_edu' => 'required|exists:side_last_educations,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada',
            'email' => 'Gunakan format email',
            'unique' => 'email telah digunakan'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

//        try {
        $user = $this->getId();

        $rsHub = rsStudentFamily::where('user_id', $user->id)->orderBy('created_at', 'asc')->get();

        foreach ($rsHub as $row) {

            $row->getFami()->update(array_merge(
                $r->only('born_place', 'address', 'name', 'phone'),
                [
                    'gender_id' => $r->sex,
                    'dob' => Carbon::createFromFormat('d/m/Y', $r->dob)->toDateString(),
                    'education_id' => $r->last_edu,
                    'profession_id' => $r->profession,
                ]
            ));
        }

        $user->update(array_merge(
            $r->only('born_place', 'address', 'email', 'name', 'phone'),
            [
                'gender_id' => $r->sex,
                'dob' => Carbon::createFromFormat('d/m/Y', $r->dob)->toDateString()
            ]
        ));

        /*  } catch (\Exception $e) {
              return $e;
          }*/
        return $this->noticeSuc();
    }
}
