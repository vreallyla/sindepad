<?php

namespace App\Http\Controllers\Api\User;

use App\DeclaredPDO\Additional\plugClass;
use App\DeclaredPDO\Jwt\jwtClass;
use App\Model\sideGender;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DeclaredPDO\Jwt\lumen\apiJWTClass as aathi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class profileController extends Controller
{
    use plugClass;

    protected $batch;

    public function edit_photo(Request $r)
    {
        //          validate must be image
        $rule = ['img' => 'required|image|max:500'];
        $msg = [
            'required' => 'gambar harus ada',
            'image' => 'format harus photo',
            'max' => 'photo maksimal 500 KB'
        ];

        if (!empty($error = $this->valid($r->only('img'), $rule, $msg))) {
            return $error;
        }
        //            end validate

        $time = now();
        $user = User::findOrFail($r->code);
        $new = $r->file('img');

//        photo check
        if ($img = $r->hasFile('img')) {
            $name = $time->format('Y_m_d_H_i_s_u') . str_random(15) . '.' . $r->img->getClientOriginalExtension();


//            checking photo user exist
            if ($this->batch = $user->url) {
                $this->batch = self::check_file_bool($this->batch);
            }

            $delete = $this->batch ? app('filesystem')->delete('public' . self::slice_storage($user->url)) : false;

//            upload photo
            if ($new->isValid()) {
                $name = Storage::disk('local')->put('public/users/photo', $new);
                $url = self::slice_public($name);

//                app('filesystem')->disk('app')->put($name, File::get($new));

                $user->update(['url' => $url]);
                return response()->json(['url' => asset($url)]);
            }

        }

    }

    private function valid($r, $rule, $msg)
    {
        $validator = Validator::make($r, $rule, $msg);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    }

    public function edit_profile(Request $r)
    {
        $user = User::findOrFail($r->code);
//        return $r;
        $rules = [
            'email' => [
                'required',
                Rule::in([$user->email]),
            ],
            'sex' => [
                'required',
                Rule::in(sideGender::all()->pluck('id')->toArray()),
            ],
            'name' => 'required',
            'date_birth' => 'required|date',
            'born_place' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ];

        $msg = [
            'required' => 'Harap isi kolom diatas',

            'in' => 'Harap tidak merubah kolom diatas',

            'date_birth.date' => 'Harap mengisi tanggal dengan format yang benar',

            'phone.numeric' => 'Harap mengisi dengan nomer',
        ];

        if (!empty($error = $this->valid($r->only('email', 'sex', 'name', 'date_birth', 'phone', 'born_place','address'), $rules, $msg))) {
            return $error;
        }

        $data['name'] = $user->name = $r->name;
        $data['stad_name']=substr($user->name,0,strpos($user->name,' '));

        $user->dob = $r->date_birth;
        $user->born_place = $r->born_place;
        $data['ttl'] = $user->born_place . ', ' . Carbon::createFromFormat('Y-m-d', $user->dob)->formatLocalized('%d %B %Y');

        $user->gender_id = $r->sex;
        $data['sex'] = sideGender::findOrFail($user->gender_id)->ind;


        $data['phone'] = $user->phone = $r->phone;
        $data['address'] = $user->address = $r->address;

        $user->update();

        return response()->json([
            'msg' => 'changes successfully',
            'data' => $data],
            200);


    }

//    private function have_sex()
//    {
//        foreach (sideGender::all() as $row){
//            $data[]=
//        }
//    }

    public function edit_password(Request $r)
    {

        try{
            $user=User::find($r->code);
        }catch (\Exception $e){
            return response()->json(['error'=>'ada kesalahan, refresh halaman atau kontak admin'],401);
        }

        if (Hash::check($r->old_password, $user->password)){
            if (Hash::check($r->new_password, $user->password)){
                return response()->json(['error'=>'harap memasukkan kata sandi berbeda'],400);
            }
            $user->update(['password'=>bcrypt($r->new_password)]);
            return response()->json(['msg'=>'Kata sandi berhasil dirubah'],200);
        }else{
            return response()->json(['error'=>'kata sandi lama salah'],400);
        }
    }

}
