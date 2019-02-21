<?php

namespace App\Http\Controllers\Api\Admin\news;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\Admin\news\MstNewsList;
use App\Model\Admin\news\RsNews;
use App\Model\Admin\news\sideNewsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class newsListController extends Controller
{
    use extraClass;

    public function sendPost(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        $new = $r->file('imgUp');

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/info', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;
            ini_set('memory_limit','180M');

            $img = Image::make($thumbnailpath)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 100)->save($thumbnailpath);

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }


            $article = MstNewsList::create(array_merge($r->only('desc', 'name'), [
                'img' => $url
            ]));

            foreach ($r->category as $row) {
                RsNews::create([
                    'mst_id' => $article->id,
                    'category_id' => $row
                ]);
            }

            return $this->noticeSuc();
        }
        return $this->noticeFail();


    }

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'row', 'page');
        $rule = [
            'cat' => 'required|exists:side_news_categories,id',
            'row' => 'required|in:9,27,45',
            'page' => 'required|numeric',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'data tidak ditemukan',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $arr = [];

        foreach (sideNewsCategory::find($r->cat)->getRs as $i => $row) {
            $row=$row->getMst;
            if ($row){
                $arr[] = array_merge($row->only('name', 'id', 'created_at'), [
                    'img' => asset($row->img)
                ]);
            }

        }

        return $this->setPaginate(($r->q ? $this->searchSome($arr, $r->q) : $arr), $r->row, $r->page);

    }

    public function getKey()
    {
        return response()->json(sideNewsCategory::orderBy('name', 'asc')->select('id', 'name')->get());
    }

    public function getEdit(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        $data = MstNewsList::find($r->key);
        $arr = [];

        foreach (MstNewsList::find($r->key)->getRel as $row) {
            $arr[] = [
                'id' => $row->getSide->id,
                'name' => $row->getSide->name
            ];
        }

        $arr = array_merge($data->only('name', 'desc', 'id'), [
            'category' => $arr,
            'img' => asset($data->img)
        ]);

        return $arr;
    }

    public function sendUpdate(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        RsNews::where('mst_id', $r->key)->delete();
        $data = MstNewsList::find($r->key);
        $arr = [];
        if ($r->has('imgUp')) {
            $new = $r->file('imgUp');

            if ($new->isValid()) {
                if ($this->conditionImg($data->img)) {
                    Storage::delete('public/' . self::slice_storage($data->img));
                }

                $name = Storage::disk('local')->put('public/info', $new);
                $url = self::slice_public($name);

                $thumbnailpath = $url;
                ini_set('memory_limit','180M');
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

        $data->update(array_merge($r->only('desc', 'name'), $arr));

        $data->getRel()->delete();

        foreach ($r->category as $row) {
            RsNews::create([
                'mst_id' => $r->key,
                'category_id' => $row
            ]);
        }

        return $this->noticeEditSuc();
    }

    public function del(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        try {
            $data = MstNewsList::find($r->key);

            if ($this->conditionImg($data->img)) {
                Storage::delete('public/' . self::slice_storage($data->img));
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
        $rule['key'] = 'required|exists:mst_news_lists,id';
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
        $re = $r->only('name', 'desc', 'imgUp', 'category');
        $rule = [
            'desc' => 'required',
            'name' => 'required',
            'imgUp' => $r->has('_method') ? 'image|max:6000' : 'required|image|max:6000',
            'category' => 'required|array|exists:side_news_categories,id',
//            'category.*' => 'required|exists:side_news_categories,id'
        ];


        $msg = [
            'required' => 'harap isi kolom diatas',
            'imgUp.image' => 'format harus photo',
            'imgUp.max' => 'photo maksimal 6 mb',
            'array' => 'format harus array',
            'exists' => 'data tidak ada'
        ];

        if ($r->has('_method')) {
            $re['key'] = $r->key;
            $rule['key'] = 'required|exists:mst_news_lists,id';
        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function searchSome($arr, $q)
    {
        $new=[];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if ($row !== 'id' || $row !== 'img') {
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
