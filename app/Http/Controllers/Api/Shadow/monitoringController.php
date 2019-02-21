<?php

namespace App\Http\Controllers\Api\Shadow;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_activities\sideActivity;
use App\Model\_student\dataScoreResult;
use App\Model\linkUserStudent;
use App\Model\sideDaylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class monitoringController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'q');
        $rule = [
            'cat' => 'required|exists:link_user_students,id',
            'q' => 'required|date_format:"d/m/Y"'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data',
//            'numeric' => 'harap isi dengan angka',
            'date_format' => 'harap tidak merubah format'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }


        $data = linkUserStudent::find($r->cat);
        $con1 = $data->status !== 'Active';
        $con2 = Carbon::parse($data->register)->addMonths(1)->lt(now());
        $con3 = $this->getId()->id !== (!$data->getShadow->isEmpty() ? $data->getShadow[0]->teacher_id : '');
        $tagetDate = Carbon::createFromFormat('d/m/Y', $r->q);
        $daySel = sideDaylist::where('en', $tagetDate->copy()->formatLocalized('%A'))->first();


        if ($con1 || $con2 || $con3) {
            return response()->json(['cat' => 'Data tidak ditemukan'], 422);
        }

        $arr = [];

        if ($data->getSche) {
            if ($data->getSche->getRs()->where('day_id', $daySel ? $daySel->id : '')->get()->isEmpty()) {
                return $this->noticeNull();
            }
            foreach ($data->getSche->getRs()->orderBy('time_start', 'asc')->where('day_id', $daySel->id)->get() as $row) {
                if ($row->getActivity) {
                    $arr[] = array_merge(['id' => $row->id
                        , 'time_start' => $row->time_start
                        , 'time_end' => $row->time_end
                        , 'name' => $row->getActivity->name
                        , 'options' => !$row->getActivity->getSubAct->isEmpty() ? $row->getActivity->getSubAct()->select('name', 'id')->get()->toArray() : []
                    ],
                        (!$data->getScore->isEmpty() ?
                            $this->getDatas($row, $data->getScore()->whereDate('date', $tagetDate->toDateString())->get())
                            : []));
                }
            }
        } else {
            return $this->noticeNull();
        }

        return empty($arr) ? $this->noticeNull() : $arr;

    }

    public function getRequest()
    {
        $label = [];
        foreach ($this->getId()->getRsHomerooms as $rows) {
            $data = $rows->getStud;
            $con1 = $data->status === 'Active';
            $con2 = Carbon::parse($data->register)->addMonths(1)->gte(now());
            $con3 = $this->getId()->id === (!$data->getShadow->isEmpty() ? $data->getShadow[0]->teacher_id : '');
            $tagetDate = now();
            $daySel = sideDaylist::where('en', $tagetDate->copy()->formatLocalized('%A'))->first();


            if ($con1 && $con2 && $con3) {

                $arr = [];
//
                if ($data->getSche) {
//                    if ($data->getSche->getRs()->where('day_id', $daySel ? $daySel->id : '')->get()->isEmpty()) {
//                        return $this->noticeNull();
//                    }
                    foreach ($data->getSche->getRs()->orderBy('time_start', 'asc')->where('day_id', $daySel ? $daySel->id : '')->get() as $row) {
                        $con = !$data->getScore->isEmpty() ?
                            $this->getDatas($row, $data->getScore()->whereDate('date', $tagetDate->toDateString())->get())
                            : [];
                        if (empty($con)) {
                            if ($row->getActivity) {
                                $arr[] = ['id' => $row->id
                                    , 'time_start' => $row->time_start
                                    , 'time_end' => $row->time_end
                                    , 'name' => $row->getActivity->name
                                ];
                            }
                        }
                    }
                }
                $label[$data->name]['list'] = $arr;
                $label[$data->name]['quantity'] = count($arr);
                $label[$data->name]['status'] = count($arr) > 0 ? true : null;


            }
        }

        return $label;
    }

    public function sendUpdate(Request $r)
    {
        if ($er = $this->valM($r)) {
            return $er;
        }

        dataScoreResult::find($r->key_score)->update(
            [
                'value' => $r->score,
                'achievement' => $r->achievement,
                'note' => $r->note,
                'sd_act_id' => $r->sub,
                'student_id' => $r->student_key,
                'date' => Carbon::createFromFormat('d/m/Y', $r->date)->toDateString(),
                'teacher_id' => $this->getId()->id,
            ]
        );

        return $this->noticeEditSuc();
    }

    public function sendPost(Request $r)
    {
        if ($er = $this->valM($r)) {
            return $er;
        }

        dataScoreResult::create(
            [
                'value' => $r->score,
                'achievement' => $r->achievement,
                'note' => $r->note,
                'sd_act_id' => $r->sub,
                'student_id' => $r->student_key,
                'date' => Carbon::createFromFormat('d/m/Y', $r->date)->toDateString(),
                'teacher_id' => $this->getId()->id,
            ]
        );

        return $this->noticeSuc();
    }

    private function valM($r)
    {
        $re = $r->only('sub', 'score', 'achievement', 'note', 'student_key', 'date');
        $rule = [
            'date' => 'required|date_format:"d/m/Y"',
            'sub' => 'required:exists:side_activities,id',
            'student_key' => 'required:exists:link_user_students,id',
            'score' => 'required',
            'achievement' => 'required',
            'note' => 'required',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada'
        ];

        if ($r->has('_method')) {
            $re['key_score'] = $r->key_score;
            $rule['key_score'] = 'required|exists:data_score_results,id';

        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $tagetDate = Carbon::createFromFormat('d/m/Y', $r->date);
        $daySel = sideDaylist::where('en', $tagetDate->copy()->formatLocalized('%A'))->first();
        $data = sideActivity::find($r->sub)->getMstAct->getRs()->where('day_id', $daySel->id)->first();
        $time_end = Carbon::parse($data->time_end)->toTimeString();


        if (Carbon::createFromFormat('Y-m-d H:i:s', $tagetDate->copy()->toDateString() . ' ' . $time_end)->gt(now())) {
            return response()->json(['note' => 'Waktu belum terlewati'], 422);
        }
    }

    private function getDatas($sche, $score)
    {
        $new = [];

        foreach ($score as $row) {
            $sche_id = $row->getSubAct ? $row->getSubAct->mst_id : null;

            if ($sche->mst_id === $sche_id) {
                $new['data'] = array_merge($row->only('value', 'achievement', 'note', 'id'),
                    [
                        'select' => [
                            'name' => $row->getSubAct->name,
                            'id' => $row->getSubAct->id
                        ]]);
            }
        }

        return $new;
    }
}
