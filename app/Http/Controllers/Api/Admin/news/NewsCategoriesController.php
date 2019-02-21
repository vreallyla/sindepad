<?php

namespace App\Http\Controllers\Api\Admin\news;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\Admin\news\RsNews;
use App\Model\Admin\news\sideNewsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsCategoriesController extends Controller
{
    use extraClass;

    public function sendPost(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }
        sideNewsCategory::create($r->only('name', 'desc'));

        return $this->noticeSuc();
    }

    public function getList(Request $r)
    {
        $re = $r->only('page', 'row');
        $rule = [
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
        $arr = sideNewsCategory::select('id', 'name', 'desc')->get()->toArray();

        return $this->setPaginate(($r->q ? $this->searchSome($arr, $r->q) : $arr), $r->row, $r->page);

    }

    public function getEdit(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        return response()->json(sideNewsCategory::find($r->key)->only('id', 'name', 'desc'));
    }

    public function sendUpdate(Request $r)
    {
        if ($er = $this->val($r)) {
            return $er;
        }

        sideNewsCategory::find($r->key)->update($r->only('name', 'desc'));

        return $this->noticeEditSuc();
    }

    public function del(Request $r)
    {
        if ($er = $this->valId($r)) {
            return $er;
        }

        foreach (RsNews::where('category_id', $r->key)->get() as $row) {
            $row->getMst()->delete();
        }
        sideNewsCategory::destroy($r->key);

        return $this->noticeDelSuc();
    }

    private function valId($r)
    {
        $re = $r->only('key');

        $rule['key'] = 'required|exists:side_news_categories,id';

        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ditemukan',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function val($r)
    {
        $re = $r->only('name', 'desc');

        $rule = [
            'name' => 'required',
            'desc' => 'required'
        ];

        if ($r->has('_method')) {
            $re ['key'] = $r->key;
            $rule['key'] = 'required|exists:side_news_categories,id';
        }
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ditemukan',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function searchSome($arr, $q)
    {
        $new=[];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if ($row !== 'id') {
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
