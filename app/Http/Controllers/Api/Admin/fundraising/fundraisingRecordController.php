<?php

namespace App\Http\Controllers\Api\Admin\fundraising;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\Peng\mstPengDana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

const CONDOTION_PENG = ['proccess', 'closed'];

class fundraisingRecordController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        $chek = mstPengDana::encodeStatus();
        $re = $r->only('cat', 'row', 'page');
        $rule = [
            'cat' => ['required', Rule::in($this->multiarray_keys($chek))],
            'row' => 'required|in:9,27,45',
            'page' => 'required|numeric',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'data tidak ditemukan',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $data = mstPengDana::when($r->has('cat'), function ($query) use ($r, $chek) {
            $query->where('status', $chek[$r->cat])
                ->when(!empty($r->q), function ($query2) use ($r) {
                    return $query2->where('name', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('target', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('desc', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('kode', 'LIKE', '%' . $r->q . '%');
                });
        })->orderBy('created_at', 'desc')->get()->toArray();

        return $this->setPaginate($data, $r->row, $r->page);
    }

    public function getCat()
    {
        return response()->json(array_values(mstPengDana::checkStatus()));
    }

    public function getEdit(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        return response()->json(mstPengDana::find($r->key));

    }

    public function sendPost(Request $r)
    {
//        return $r;
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('imgUp');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/fundraising', $new);
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

            mstPengDana::create([
                'kode' => mstPengDana::codeFund(),
                'name' => $r->name,
                'desc' => $r->detail,
                'url' => $url,
                'status' => mstPengDana::encodeStatus()[CONDOTION_PENG[0]],
                'target' => $r->target
            ]);

            return $this->noticeSuc();
        }
        return $this->noticeFail();
    }

    public function sendUpdate(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $data = mstPengDana::find($r->key);
        $arr = [];
        if ($r->has('imgUp')) {
            $new = $r->file('imgUp');

            if ($new->isValid()) {
                if ($this->conditionImg($data->img)) {
                    Storage::delete('public/' . self::slice_storage($data->url));
                }

                $name = Storage::disk('local')->put('public/info', $new);
                $url = self::slice_public($name);

                $thumbnailpath = $url;
                ini_set('memory_limit', '180M');
                $img = Image::make($thumbnailpath)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->encode('jpg', 100)->save($thumbnailpath);

                if (!file_exists($url)) {
                    return response()->json(['msg' => 'upload gambar gagal'], 400);
                }

                $arr['img'] = $url;

            }
        }

        $data->update(
            [
                'name' => $r->name,
                'desc' => $r->detail,
                'url' => isset($url) ? $url : $data->url,
                'status' => mstPengDana::encodeStatus()[CONDOTION_PENG[$r->target >= $data->collected ? 0 : 1]],
                'target' => $r->target
            ]
        );

        return $this->noticeEditSuc();
    }

    public function del(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        try {
            $data = mstPengDana::find($r->key);

            if ($this->conditionImg($data->url)) {
                Storage::delete('public/' . self::slice_storage($data->img));
            }

            if (!$data->getContributor->isEmpty()){
                foreach ($data->getContributor as $row){
                    if ($this->conditionImg($row)) {
                        Storage::delete('public/' . self::slice_storage($row->img));
                    }
                }
            }

            $data->delete();

        } catch (\Exception $e) {
            return $this->noticeFail();
        }

        return $this->noticeDelSuc();
    }

    private function valId($r)
    {
        $re = $r->only('key');
        $re['key'] = $r->key;
        $rule['key'] = 'required|exists:mst_peng_danas,id';
        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'data tidak ada'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function val($r)
    {
        $chek = mstPengDana::encodeStatus();
        $re = $r->only('name', 'detail', 'imgUp', 'target');
        $rule = [
            'detail' => 'required',
            'name' => 'required',
            'imgUp' => $r->has('_method') ? 'image|max:6000' : 'required|image|max:6000',
            'target' => 'required|numeric|min:50000|max:999999999999'
        ];


        $msg = [
            'required' => 'harap isi kolom diatas',
            'imgUp.image' => 'format harus photo',
            'imgUp.max' => 'photo maksimal 6 mb',
            'numeric' => 'Harap isi dengan angka',
            'min' => 'Minimal 50000',
            'max' => 'Maksimal 999999999999'
        ];

        if ($r->has('_method')) {
            $re['key'] = $r->key;
            $rule['key'] = 'required|exists:mst_peng_danas,id';
        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }


}
