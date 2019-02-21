<?php

namespace App\Http\Controllers\Api\Admin\studentConfig\schedules;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_activities\mstActivity;
use App\Model\_sche\mstSchecule;
use App\Model\_sche\rsSchecule;
use App\Model\sideDaylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class schedulesController extends Controller
{
    use extraClass;

    public function ScheGetList(Request $r)
    {

        if ($er = $this->valPaginateWithoutCat($r, [10, 30, 50])) {
            return $er;
        }

        $arr = mstSchecule::orderBy('created_at', 'desc')->select('id', 'name', 'desc')->get()->toArray();

        return $this->setPaginate(($r->q ? $this->searchSomeComp($arr, $r->q, ['id']) : $arr), $r->row, $r->page);
    }

    public function postSche(Request $r)
    {
        if ($er = $this->valSche($r)) {
            return $er;
        }

        try {
            mstSchecule::create($r->only('name', 'desc'));

        } catch (\Exception $e) {
            return $this->noticeFail();
        }
        return $this->noticeSuc();

    }

    public function editSche(Request $r)
    {
        if ($er = $this->valScheId($r)) {
            return $er;
        }

        try {
            return response()->json(mstSchecule::find($r->key)->only('name', 'desc', 'id'));
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

    }

    public function updateSche(Request $r)
    {
        if ($er = $this->valSche($r)) {
            return $er;
        }
        try {
            mstSchecule::find($r->key)->update($r->only('name', 'desc'));
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

        return $this->noticeEditSuc();
    }

    public function delSche(Request $r)
    {
        if ($er = $this->valScheId($r)) {
            return $er;
        }

        try {
            $data = mstSchecule::find($r->key);
            $data->getRs()->delete();
            $data->delete();
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

        return $this->noticeDelSuc();
    }

    public function sideGetList(Request $r)
    {
        if ($er = $this->valScheId($r)) {
            return $er;
        }

        $day = sideDaylist::orderBy('created_at', 'asc')->get();
        $arr = [];

        foreach ($day as $row) {
            $arr[] = [
                'name' => $row->ind,
                'key' => $row->id,
                'list' => $this->dayList($row, $r->key)

            ];
        }

        return response()->json($arr);

    }

    public function postAct(Request $r)
    {

        if ($error = $this->validD($r)) {
            return $error;
        }

        $start = Carbon::parse($r->time_start);
        $end = Carbon::parse($r->time_end);
        $day = sideDaylist::find($r->key);

        if ($start->copy()->eq($end)) {
            return response()->json(['time_end' => 'waktu tidak boleh sama'], 422);
        } elseif ($start->copy()->gt($end)) {
            return response()->json(['time_end' => 'waktu kanan tidak boleh lebih kecil'], 422);
        }

        if (!$r->has('con')) {
            $range = mstActivity::find($r->sel_act)->time;
            if (!$start->copy()->addMinutes($range)->eq($end)) {
                return response()->json(['time_end' => 'Harap tidak merubah data'], 422);
            }
        }

        if (!$day->rsSchedules->isEmpty()) {
//return response()->json(['s'=>$start],400);

            $timeSame = $day->rsSchedules()->whereTime('time_start', '=', $start->toTimeString())->orderBy('time_end', 'desc')->first();
            $timePrev = $day->rsSchedules()->whereTime('time_start', '<', $start->toTimeString())->orderBy('time_end', 'desc')->first();
            $timeNext = $day->rsSchedules()->whereTime('time_start', '>', $start->toTimeString())->orderBy('time_end', 'asc')->first();
            $timeLast = $day->rsSchedules()->orderBy('time_start', 'desc')->first();


            $con1 = $timePrev ? Carbon::parse($timePrev->time_end)->gt($start) : false;
            $con2 = $timeNext ? Carbon::parse($timeNext->time_start)->lt($end) : false;
            $con3 = $timeSame;
            $con4 = $timeNext ? false :
                Carbon::parse($timeLast->time_end)->gt($start);
            if ($con1 || $con2 || $con3 || $con4) {
                return response()->json(['time_end' => 'waktu tidak dapat digunakan'], 422);
            }

        }


        rsSchecule::create(array_merge(($r->has('con') ? [
            'act_other' => $r->act_other
        ] : [
            'mst_id' => $r->sel_act]), [
            'time_start' => $r->time_start,
            'time_end' => $r->time_end,
            'day_id' => $r->key,
            'sche_id' => $r->key_sche
        ]));

        return $this->noticeSuc();
    }

    public function updateAct(Request $r)
    {
        if ($error = $this->validD($r)) {
            return $error;
        }

        $start = Carbon::parse($r->time_start);
        $end = Carbon::parse($r->time_end);
        $day = sideDaylist::find($r->key);
        $data = rsSchecule::find($r->rs_key);

        if ($start->eq($end)) {
            return response()->json(['time_start' => 'waktu tidak boleh sama'], 422);
        } elseif ($start->gt($end)) {
            return response()->json(['time_start' => 'waktu kanan tidak boleh lebih kecil'], 422);
        }

        if (!$r->has('con')) {
            $range = mstActivity::find($r->sel_act)->time;
            if (!$start->addMinutes($range)->eq($end)) {
                return response()->json(['time_end' => 'Harap tidak merubah data'], 422);
            }
        }

        if (!$day->rsSchedules->isEmpty()) {

            $timePrev = $day->rsSchedules()->whereTime('time_start', '<', $data->time_start)->orderBy('time_end', 'desc')->first();
            $timeNext = $day->rsSchedules()->whereTime('time_start', '>', $data->time_start)->orderBy('time_end', 'asc')->first();
//

            $con1 = $timePrev ? Carbon::parse($timePrev->time_end)->gt($start) : false;
            $con2 = $timeNext ? Carbon::parse($timeNext->time_start)->lt($end) : false;


            if ($con1 || $con2) {
                return response()->json(['time_end' => 'waktu tidak dapat digunakan'], 422);
            }

        }

        $data->update(array_merge(($r->has('con') ? [
            'act_other' => $r->act_other,
            'mst_id' => null
        ] : [
            'mst_id' => $r->sel_act,
            'act_other' => null
        ]), [
            'time_start' => $r->time_start,
            'time_end' => $r->time_end,
            'day_id' => $r->key
        ]));

        return $this->noticeSuc();
    }

    public function deleteAct(Request $r)
    {

        $re = $r->only('key');

        $rule = [
            'key' => 'required|exists:rs_schecules,id'
        ];
        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'Harap tidak merubah data'
        ];


        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        try {
            rsSchecule::destroy($r->key);
        } catch (\Exception $r) {

            return $this->noticeFail();
        }

        return response()->json(['msg' => 'data berhasil dihapus']);
    }

    private function valScheId($r)
    {
        $re['key'] = $r->has('key') ? $r->key : '';
        $rule['key'] = 'required|exists:mst_schecules,id';

        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'Harap tidak merubah data'
        ];


        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function valSche($r)
    {
        $re = $r->only('name', 'desc');

        $rule = [
            'name' => 'required',
            'desc' => 'required'
        ];

        if ($r->has('_method')) {
            $re['key'] = $r->key;
            $rule['key'] = 'required|exists:mst_schecules,id';
        }

        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

    }

    private function validD($r)
    {
        $re = $r->has('con') ? $r->only('key', 'act_other', 'time_start', 'time_end', 'key_sche') :
            $r->only('key', 'sel_act', 'time_start', 'time_end', 'key_sche');

        $rule = array_merge(($r->has('con') ? [
            'act_other' => 'required'
        ] : [
            'sel_act' => 'required|exists:mst_activities,id']), [
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'key' => 'required|exists:side_daylists,id',
            'key_sche' => 'required|exists:mst_schecules,id'
        ]);
        $msg = [
            'required' => 'harap isi kolom diatas',
            'exists' => 'Harap tidak merubah data',
            'date_format' => 'format harus jam:menit',

        ];

        if ($r->has('_method')) {
            $re['rs_key'] = $r->rs_key;
            $rule['rs_key'] = 'required|exists:rs_schecules,id';
        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

    }


}
