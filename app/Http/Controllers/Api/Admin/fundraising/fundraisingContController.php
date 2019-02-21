<?php

namespace App\Http\Controllers\Api\Admin\fundraising;

use App\DeclaredPDO\Jwt\extraClass;
use App\Mail\confirmContMail;
use App\Model\Peng\mstPengDana;
use App\Model\Peng\sidePengDana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class fundraisingContController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'page', 'row');
        $rule = [
            'cat' => [
                'required',
                Rule::in(array_values(sidePengDana::checkStatus()))
            ],
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

        $data = sidePengDana::where('status', sidePengDana::encodeStatus()[$r->cat])->when($r->q, function ($query) use ($r) {
            return $query->where('an', 'LIKE', '%' . $r->q . '%')
                ->orWhere('email', 'LIKE', '%' . $r->q . '%')
                ->orWhere('url', 'LIKE', '%' . $r->q . '%')
                ->orWhere('nominal', 'LIKE', '%' . $r->q . '%')
                ->orWhere('date', 'LIKE', '%' . $r->q . '%');
        })->orderBy('created_at', 'desc')->get()->toArray();

        return $this->setPaginate($data, $r->row, $r->page);
    }

    public function postContributor(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('imgUp');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/fundraising/cont', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;
            ini_set('memory_limit', '180M');

            $img = Image::make($thumbnailpath)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 100)->save($thumbnailpath)->destroy();

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }

            sidePengDana::create([
                'an' => $r->name,
                'date' => $r->date_trans,
                'email' => $r->email,
                'nominal' => $r->nominal,
                'url' => $url,
                'status' => 'belum terkonfirmasi',
                'mst_id' => $r->key_sumb
            ]);

//            $fund = mstPengDana::find($r->key_sumb);

            return response()->json(['msg' => 'Berhasil Terkirim, Konfirmasi penerimaan dikirim lewat email']);
        }
        return $this->noticeFail();
    }

    public function postStatSuc(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('imgUp');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/fundraising/cont', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;
            ini_set('memory_limit', '180M');

            $img = Image::make($thumbnailpath)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 100)->save($thumbnailpath)->destroy();

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }

            $cont=sidePengDana::create([
                'an' => $r->name,
                'date' => $r->date_trans,
                'email' => $r->email,
                'nominal' => $r->nominal,
                'url' => $url,
                'status' => 'sudah terkonfirmasi',
                'mst_id' => $r->fund
            ]);

            Mail::to($cont->email)->send(new confirmContMail($cont));

            return $this->noticeSuc();
        }
        return $this->noticeFail();
    }

    public function sendCHage(Request $r)
    {
        if ($er = $this->valID($r)) {
            return $er;
        }

        try {
            $cont=sidePengDana::find($r->key_cont);
            $mst=$cont->getObjN;
            $arNom=sidePengDana::where('mst_id',$mst->key)->where('status','sudah terkonfirmasi')->pluck('nominal');

            if ($r->key_status==='verified'){
                Mail::to($cont->email)->send(new confirmContMail($cont));
            }

            if ($mst->target>=$arNom?array_sum($arNom):0){
                $mst->update([
                    'status'=>'Sukses'
                ]);
            }
            else{
                $mst->update([
                    'status'=>'Proses'
                ]);
            }

            $cont->update([
                'status' => sidePengDana::encodeStatus()[$r->key_status]
            ]);

            return $this->noticeEditSuc();
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

    }

    public function valID($r)
    {
        $re = $r->only('key_cont', 'key_status');
        $rule = [
            'key_cont' => 'required|exists:side_peng_danas,id',
            'key_status' => ['required', Rule::in(array_values(sidePengDana::checkStatus()))]
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada',
            'in' => 'Data tidak ada'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function val($r)
    {
        $chage='required|exists:mst_peng_danas,id';
        $re = $r->only('imgUp', 'name', 'date_trans', 'email', 'nominal');
        $rule = [
            'imgUp' => 'required|image|max:6000',
            'name' => 'required|min:3|max:32',
            'date_trans' => 'required|date_format:"Y-m-d"',
            'email' => 'required|email|max:36',
            'nominal' => 'required|numeric',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'image' => 'Harap isi dengan gambar',
            'email' => 'Harap masukan email dengan benar',
            'name.min' => 'minimal 3 huruf',
            'name.max' => 'maksimal 32 huruf',
            'email.max' => 'maksimal 36 huruf',
            'date_format' => 'format: ' . now()->toDateString(),
            'exists' => 'Harap tidak merubah data',
            'key_sumb.required' => 'Harap tidak merubah data'
        ];

        if ($r->has('fund')){
            $re['fund']=$r->fund;
            $rule['fund']=$chage;
        }else{
            $re['key_sumb']=$r->key_sumb;
            $rule['key_sumb']=$chage;
        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

    }
}
