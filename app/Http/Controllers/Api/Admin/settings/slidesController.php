<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\Admin\settings\DataSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class slidesController extends Controller
{
    use extraClass;

    public function getList()
    {
        $arr = [];

        foreach (DataSlide::orderBy('created_at', 'desc')->get() as $row) {
            $arr[] = array_merge($row->only('img', 'link', 'desc'), [
                'key' => $row->id
            ]);
        }

        return empty($arr) ? $this->noticeNull() : response()->json($arr);
    }

    public function post(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('img');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/settings/carousel', $new);
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


            DataSlide::create([
                'link' => $r->link,
                'img' => $url,
                'desc' => $r->desc
            ]);

        }
        return $this->noticeSuc();
    }

    public function change(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('img');
        $data = DataSlide::find($r->key);
        $plus=[];
        if ($new){
            if ($new->isValid()) {


                if ($this->conditionImg($data->img)) {
                    Storage::delete('public/' . self::slice_storage($data->img));
                }

                $name = Storage::disk('local')->put('public/settings/carousel', $new);
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

                $plus['img']=$url;

            }
        }

        $data->update(array_merge($r->except('key', 'img'), $plus));

        return $this->noticeEditSuc();
    }

    public function del(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        $data = DataSlide::find($r->key);

        if ($this->conditionImg($data->img)) {
            Storage::delete('public/' . self::slice_storage($data->img));
        }

        $data->delete();


        return $this->noticeDelSuc();
    }

    public function getedit(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        return response()->json(DataSlide::find($r->key)->only('desc', 'link'));
    }

    private function valId($r)
    {
        $re = $r->only('key');

        $rule['key'] = 'required|exists:data_slides,id';


        $msg = [
            'required' => 'harap key diisi',
            'exists' => 'key tidak terdaftar',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function delImg($url)
    {
        if ($this->conditionImg($url)) {
            Storage::delete('public/' . self::slice_storage($url));
        }
    }

    private function val($r)
    {
        $re = $r->only('desc', 'img', 'link', 'key');
        $rule = [
            'desc' => 'required',
            'link' => 'required',
            'img' => $r->has('key') ? 'image|max:6000' : 'required|image|max:6000'
        ];
        if ($r->has('key')) {
            $rule['key'] = 'required|exists:data_slides,id';
        }


        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'key tidak terdaftar',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }
}
