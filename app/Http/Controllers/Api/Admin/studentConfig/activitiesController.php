<?php

namespace App\Http\Controllers\Api\Admin\studentConfig;

use App\DeclaredPDO\Additional\plugClass;
use App\DeclaredPDO\Jwt\extraClass;
use App\DeclaredPDO\response;
use App\Model\_activities\mstActivity;
use App\Model\_activities\sideActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class activitiesController extends Controller
{
    use extraClass;

    public function post(Request $r)
    {
        $re = $r->only('detail', 'name', 'img', 'purpose', 'span');
        $rule = [
            'detail' => 'required|max:16000',
            'name' => 'required|min:3|max:50',
            'img' => 'required|image|max:6000',
            'purpose' => 'required|max:50',
            'span' => 'required|numeric|min:15|max:120'
        ];
        $msg = [
            'required' => 'harap isi kolom diatas',
            'img.image' => 'format harus photo',
            'img.max' => 'photo maksimal 6 mb',
            'span.min' => 'minimal waktu 15 menit',
            'span.max' => 'maksimal waktu 120 menit',
            'name.max' => 'huruf maksimal 50',
            'purpose.max' => 'huruf maksimal 50',
            'detail.max' => 'huruf maksimal 16000'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $new = $r->file('img');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/settings/schedules', $new);
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

          try{
              mstActivity::create([
                  'code' => $this->kodeSet(new mstActivity(), 'MT', 'code'),
                  'name' => $r->name,
                  'purpose' => $r->purpose,
                  'url' => $url,
                  'summary' => $r->detail,
                  'time' => $r->span
              ]);
          }catch(\Exception $e){
              Storage::delete('public/' . self::slice_storage($url));
              return $this->noticeFail();
          }

            return $this->noticeSuc();
        }
        return $this->noticeFail();
    }

    public function getList(Request $r)
    {
        $re = $r->only('page', 'row');
        $rule = [
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

        $data = mstActivity::orderBy('created_at', 'desc')->get();
        $arr = [];

        foreach ($data as $i => $row) {
            $arr[] = array_merge($row->only('name', 'code'), [
                'span' => $row->time,
                'key' => $row->id,
                'img' => asset($row->url)
            ]);
        }

        return $this->setPaginate(($r->q ? $this->searchSome($arr, $r->q) : $arr), $r->row, $r->page);
    }

    public function detail(Request $r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:mst_activities,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $data = mstActivity::find($r->key);
        $arr = array_merge($data->only('name', 'code','time', 'purpose', 'summary'), ['img' => $this->checkImg($data->url)]);


        $arr['list'] = !$data->getSubAct->isEmpty() ? $this->getDataSub($data) : [];

        return response()->json($arr);
    }

    public function sub(Request $r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:side_activities,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        return response()->json(sideActivity::find($r->key)->only('id', 'name', 'target', 'desc'));
    }

    public function subEdit(Request $r)
    {
        $re = $r->only('keyAc', 'key', 'name', 'target', 'desc');
        $rule = [
            'keyAc' => 'required|exists:mst_activities,id',
            'key' => 'required|exists:side_activities,id',
            'name' => 'required',
            'target' => 'required',
            'desc' => 'required',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];
        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $data = sideActivity::find($r->key);

        if ($data->mst_id !== $r->keyAc) {
            return $this->noticechangeData();
        }

        $data->update($r->only('name', 'target', 'desc'));
        return $this->listSubActive($r->keyAc, 'dirubah');
    }

    public function subPost(Request $r)
    {
        $re = $r->only('keyAc', 'name', 'target', 'desc');
        $rule = [
            'keyAc' => 'required|exists:mst_activities,id',
            'name' => 'required',
            'target' => 'required',
            'desc' => 'required',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];
        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        sideActivity::create([
            'name' => $r->name,
            'target' => $r->target,
            'desc' => $r->desc,
            'mst_id' => $r->keyAc,
        ]);
        return $this->listSubActive($r->keyAc, 'dibuat');
    }

    public function actEdit(Request $r)
    {
        if ($err = $this->validAct($r->only('key'))) {
            return $err;
        }

        $data = mstActivity::find($r->key);
        return response()->json(array_merge($data->only('name', 'purpose'), ['key' => $data->id, 'detail' => $data->summary, 'span' => $data->time]));
    }

    public function actUpdate(Request $r)
    {
        $re = $r->only('detail', 'name', 'img', 'purpose', 'span', 'key');
        $rule = [
            'detail' => 'required',
            'name' => 'required|min:3',
            'img' => 'image|max:6000',
            'purpose' => 'required',
            'span' => 'required|numeric|min:15|max:120',
            'key' => 'required|exists:mst_activities,id'
        ];
        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'harap tidak merubah data',
            'img.image' => 'format harus photo',
            'img.max' => 'photo maksimal 6 mb',
            'span.min' => 'minimal waktu 15 menit',
            'span.max' => 'maksimal waktu 120 menit'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        if ($r->hasFile('img')) {
            return $this->hasImgUpd($r);
        } else {
            mstActivity::find($r->key)->update([
                'code' => $this->kodeSet(new mstActivity(), 'MT', 'code'),
                'name' => $r->name,
                'purpose' => $r->purpose,
                'summary' => $r->detail,
                'time' => $r->span
            ]);

            return $this->noticeSuc();
        }

    }

    private function hasImgUpd($r)
    {
        $new = $r->file('img');
        $data = mstActivity::find($r->key);

        if ($new->isValid()) {

            if ($this->conditionImg($data->url)) {
                Storage::delete('public/' . self::slice_storage($data->url));
            }

            $name = Storage::disk('local')->put('public/settings/schedules', $new);
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

            $data->update([
                'code' => $this->kodeSet(new mstActivity(), 'MT', 'code'),
                'name' => $r->name,
                'purpose' => $r->purpose,
                'url' => $url,
                'summary' => $r->detail,
                'time' => $r->span
            ]);

            return $this->noticeSuc();
        }

        return $this->noticeFail();
    }

    public function actDel(Request $r)
    {
        if ($err = $this->validAct($r->only('key'))) {
            return $err;
        }

        mstActivity::find($r->key)->getSubAct()->delete();
        mstActivity::destroy($r->key);

        return response()->json(['msg' => 'berhasil dihapus']);
    }

    private function validAct($key)
    {
        $rule = [
            'key' => 'required|exists:mst_activities,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($key, $rule, $msg)) {
            return $error;
        }

    }

    public function subDel(Request $r)
    {

        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:side_activities,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
        $data = sideActivity::find($r->key);
        $mst = $data->mst_id;
        $data->delete();
        return $this->listSubActive($mst, 'dihapus');

    }

    private function listSubActive($id, $notic)
    {
        return array_merge(['msg' => 'Berhasil ' . $notic], ['list' => $this->getDataSub(mstActivity::find($id))]);
    }

    private function getDataSub($data)
    {
        $arr = [];
        if (!$data->getSubAct->isEmpty()) {
            foreach ($data->getSubAct()->orderBy('name', 'asc')->get() as $i => $row) {
                $arr[] = ['name' => $row->name, 'key' => $row->id];
            }
        }
        return $arr;
    }

    private function searchSome($arr, $q)
    {
        $new = [];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if ($row !== 'key' || $row !== 'img') {
                    if (strpos(strtolower($tow[$row]), strtolower($q)) !== false) {
                        $new[] = $tow;
                        break;
                    }
                }
            }

        }
        return $new;
    }


}
