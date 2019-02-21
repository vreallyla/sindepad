<?php

namespace App\Http\Controllers\Api\Shadow;

use App\DeclaredPDO\Admin\Master\users;
use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class setScheStudentController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        if ($er = $this->valPaginateWithCat($r, [
            10, 30, 50
        ], [
            'Sudah Diatur',
            'Belum Diatur'
        ])) {
            return $er;
        }

        $arr = $this->getListStudentN($r->cat);

        return $this->setPaginate(($r->q ? users::searchSome($arr, $r->q) : $arr), $r->row, $r->page);
    }


    public function setSche(Request $r)
    {


        $re = $r->only('key_student', 'key_sche');
        $rule = [
            'key_student' => 'required|exists:link_user_students,id',
            'key_sche' => 'required|exists:mst_schecules,id'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        linkUserStudent::find($r->key_student)->update([
            'sche_id' => $r->key_sche
        ]);

        return $this->noticeEditSuc();
    }

    public function checkRequest()
    {
        $arr = $this->getListStudentN('Belum Diatur');

        if (!empty($arr)) {
            $data = [
                'notice' => true,
                'quantity' => count($arr),
                'list' => $arr
            ];
        } else {
            $data = [
                'notice' => null,
                'quantity' => count($arr),
                'list' => $arr
            ];
        }

        return $data;
    }

    private function getListStudentN($check)
    {
        $data = linkUserStudent::where('status', 'Active')->orderBy('updated_at', 'desc')->get();

        $arr = [];

        foreach ($data as $row) {
            $con = $row->sche_id;
            $shaN=$row->getShadow()->first();
            if (($shaN?$shaN->getTeacher->id:'') === $this->getId()->id)
                if ($check === 'Sudah Diatur' ? $con : !$con) {
                    $date = Carbon::parse($row->register);
                    $arr[] = array_merge([
                        'key' => $row->id,
                        'img'=>$this->checkImg($row->url),
                        'numb_regist' => $row->ni,
                        'name' => $row->name,
                        'needed' => $this->getNeeded($row->getDisablity),
                        'status' => [
                            'notice' => $date->copy()->addMonths(1)->gt(now()) ? 'Aktif' : 'Administrasi',
                            'time' => $date->copy()->addMonths(1)
                        ]], $row->sche_id ?
                        ['schedule' => ['name' => $row->getSche->name,
                            'key' => $row->getSche->id]]
                        : []);
                }

        }

        return $arr;
    }


}
