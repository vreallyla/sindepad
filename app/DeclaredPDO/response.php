<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 29/11/2018
 * Time: 1:22
 */

namespace App\DeclaredPDO;


use App\Model\Peng\mstPengDana;
use App\Model\sideStatusUser;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;


trait response
{
    private function noticeNull()
    {
        return response()->json(['msg' => 'data kosong'], 403);

    }

    private function noticeFail()
    {
        return response()->json(['msg' => 'Gagal dibuat'], 406);

    }

    private function noticeDelSuc()
    {
        return response()->json(['msg' => 'berhasil dihapus'], 200);

    }

    private function noticeEditSuc()
    {
        return response()->json(['msg' => 'berhasil dirubah'], 200);

    }

    private function noticEditPlusData($data)
    {
        return response()->json([
            'msg' => 'berhasil dirubah',
            'data' => $data
        ], 200);
    }

    private function noticeSuc()
    {
        return response()->json(['msg' => 'berhasil dibuat'], 200);

    }

    private function noticeAccess()
    {
        return response()->json(['msg' => 'Kamu tidak memiliki akses'], 401);

    }

    private function noticechangeData()
    {
        return response()->json(['msg' => 'Harap tidak mengganti data'], 405);
    }

    private function notFound()
    {
        return response()->json(['msg' => 'Halaman tidak ditemukan'], 404);
    }

    private function checkImg($img)
    {
        return File::exists($img) ? asset($img) : asset('images/img_unvailable.png');
    }

    private function conditionImg($img)
    {
        return File::exists($img) ? asset($img) : false;
    }

    private function getNeeded($rel)
    {
        $str = '';
        foreach ($rel as $row) {

            $str .= $row->getDetailDis->name . ', ';
        }
        return $str ? substr($str, 0, -2) : '';

    }

    private function niSet($model, $code)
    {
        do {
            $kode = $code . now()->format('ym') . sprintf("%04d", rand(0001, 9999));
        } while (!$model->where('ni', $kode)->get());

        return $kode;
    }

    private function kodeSet($model, $code, $target)
    {
        do {
            $kode = $code . now()->format('ym') . sprintf("%04d", rand(0001, 9999));
        } while (!$model->where($target, $kode)->get());

        return $kode;
    }

    private function getUserStatus($role)
    {
        $status = sideStatusUser::where('ind', $role)->first();

        if (isset($status)) {
            return $status->id;
        }

    }


    /*---------------------------- schedule ---------------------------------*/
    private function dayList($r, $key)
    {
        $arr = [];

        if (!$r->rsSchedules->isEmpty()) {
            foreach ($r->rsSchedules()->where('sche_id', $key)->orderBy('time_start', 'asc')->get() as $row) {
                if ($row->getActivity||$row->act_other) {
                    $arr[] = array_merge($row->only('time_start', 'time_end'), [
                        'name' => $row->getActivity ? $row->getActivity->name : $row->act_other,
                        'key' => $row->getActivity ? $row->getActivity->id : null,
                        'code' => $row->getActivity ? $row->getActivity->code : null,
                        'rs_key' => $row->id
                    ]);
                }
            }
        }
        return $arr;
    }

    /*---------------------------- schedule ---------------------------------*/


    /*---------------------------------------- search comp ---------------------------------------- */
    private function searchSomeComp($arr, $q, $except)
    {
        $new = [];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if (!array_key_exists($row, $except)) {
                    if (strpos(strtolower($tow[$row]), strtolower($q)) !== false) {
                        $new[] = $tow;
                        break;
                    }
                }
            }

        }
        return $new;
    }

    /*-------------------------------------- end search comp -------------------------------------- */

    private function valPaginateWithoutCat($r, $row)
    {
        $re = $r->only('page', 'row');
        $rule = [
            'page' => 'required|numeric',
            'row' => [
                'required',
                Rule::in($row)
            ]
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function valPaginateWithCat($r, $row, $cat)
    {
        $re = $r->only('page', 'row', 'cat');
        $rule = [
            'page' => 'required|numeric',
            'row' => [
                'required',
                Rule::in($row)
            ], 'cat' => [
                'required',
                Rule::in($cat)
            ]
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function multiarray_keys($ar) {

        foreach($ar as $k => $v) {
            $keys[] = $k;
            if (is_array($ar[$k]))
                $keys = array_merge($keys, $this->multiarray_keys($ar[$k]));
        }
        return $keys;
    }


}