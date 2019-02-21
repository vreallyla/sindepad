<?php

namespace App\Http\Controllers\Api\Admin\Trans;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tuitionsController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'row', 'page');
        $rule = [
            'row' => 'required|in:10,30,50',
            'page' => 'required|numeric',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }


        $arr = [];

        $student = linkUserStudent::orderBy('register', 'desc')->get();

        foreach ($student as $row) {
            $regist = Carbon::parse($row->register);
            $exp_date = $regist->copy()->addMonths(1);

            if (now()->gt($exp_date)) {
                $arr[] = array_merge($row->only('ni', 'name'), [
                    'gender' => $row->getSex->ind,
                    'exp_date' => $exp_date,
                    'regist' => $regist,
                    'key' => $row->id
                ]);
            }
        }
        return $this->setPaginate(($r->q?$this->searchTutions($arr,$r->q):$arr), $r->row, $r->page);
    }

    public function deals(Request $r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'key tidak ditemukan',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $student=linkUserStudent::find($r->key);
        $student->update([
           'register'=>Carbon::parse($student->register)->addMonths(1)
        ]);

        return $this->noticeSuc();
    }

    private function searchTutions($arr,$q)
    {
        $new = [];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if ($row !== 'key') {
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
