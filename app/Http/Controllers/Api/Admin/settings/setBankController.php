<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\order\payingMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\ImageException;
use Intervention\Image\Facades\Image;

class setBankController extends Controller
{
    use extraClass;

    public function getList()
    {
        $data = payingMethod::where('method', 'Transfer')->orderBy('created_at', 'desc')->get();
        $arr = [];

        foreach ($data as $row) {
            $arr[] = array_merge($row->only('name'), [
                'key' => $row->id,
                'img' => $this->checkImg($row->url),
                'bank' => [
                    'key' => $row->bank_id
                    , 'name' => $row->get_bank->name
                ]
            ]);
        }

        return $this->setPaginate($arr, count($data), 1);
    }

    public function sendPost(Request $r)
    {
        if ($er = $this->valD($r)) {
            return $er;
        }

        $new = $r->file('img');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/label/banks', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;

            try {
                $img = Image::make($thumbnailpath)->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->encode('jpg', 100)->save($thumbnailpath);
            } catch (ImageException $e) {
                Storage::delete($name);
                return $this->noticeFail();
            }

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }

            payingMethod::create([
                'name' => $r->name,
                'url' => $url,
                'bank_id' => $r->bank,
                'method' => 'Transfer',
                'name_owner' => $r->an,
                'division' => $r->division,
                'no_rek' => str_replace(' ', '', $r->no_rek),
            ]);

            return $this->noticeSuc();
        }
        return $this->noticeFail();
    }

    public function setUpdate(Request $r)
    {
        if ($er = $this->valD($r)) {
            return $er;
        }

        $new = $r->file('img');
        $data = payingMethod::find($r->key);

        if ($r->has('img') ? $new->isValid() : false) {

            if ($this->conditionImg($data->url)) {
                Storage::delete('public/' . self::slice_storage($data->url));
            }

            $name = Storage::disk('local')->put('public/label/banks', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;

            try {
                $img = Image::make($thumbnailpath)->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->encode('jpg', 100)->save($thumbnailpath);
            } catch (ImageException $e) {
                Storage::delete($name);
                return $this->noticeFail();
            }

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }

        }

        $data->update([
            'name' => $r->name,
            'bank_id' => $r->bank,
            'url' => isset($url) ? $url : $data->url,
            'name_owner' => $r->an,
            'division' => $r->division,
            'no_rek' => str_replace(' ', '', $r->no_rek),
        ]);

        return $this->noticeSuc();
    }

    public function getEdit(Request $r)
    {
        if ($er = $this->valKey($r)) {
            return $er;
        }

        try{
            return payingMethod::find($r->key)->only('name','name_owner','division','no_rek');
        }catch (\Exception $e){
            return $this->noticeFail();
        }

    }

    public function setDel(Request $r)
    {
        if ($er = $this->valKey($r)) {
            return $er;
        }

        try{
            payingMethod::destroy($r->key);
            return $this->noticeDelSuc();
        }catch (\Exception $e){
            return $this->noticeDelSuc();
        }

    }

    private function valKey($r)
    {
        $re = $r->only('key');
        $rule['key'] = 'required|exists:paying_methods,id';
        $msg = [
            'exists' => 'Data tidak ada',
            'required' => 'harap isi kolom diatas'];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

    }

    private function valD($r)
    {
        $re = $r->only('bank', 'name', 'img', 'an', 'division'
        );
        $re['no_rek'] = str_replace(' ', '', $r->has('no_rek') ? $r->no_rek : ' ');
        $rule = [
            'name' => 'required',
            'img' => ($r->has('_method') ? '' : 'required|') . 'image|max:6000',
            'bank' => 'required|exists:data_banks,id',
            'an' => 'required', 'division' => 'required',
            'no_rek' => 'required|numeric'
        ];

        if ($r->has('_method')) {
            $re['key'] = $r->key;
            $rule['key'] = 'required|exists:paying_methods,id';
        }

        $msg = [
            'exists' => 'Data tidak ada',
            'required' => 'harap isi kolom diatas',
            'img.image' => 'format harus photo',
            'img.max' => 'photo maksimal 6 mb',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }
}
