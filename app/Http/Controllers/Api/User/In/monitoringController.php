<?php

namespace App\Http\Controllers\Api\User\In;

use App\DeclaredPDO\Jwt\extraClass;
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
            'in' => 'Harap tidak merubah data',
            'numeric' => 'harap isi dengan angka',
            'date_format' => 'harap tidak merubah format'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }


        $data = linkUserStudent::find($r->cat);
        $con1 = $data->status !== 'Active';
        $con2 = Carbon::parse($data->register)->addMonths(1)->lt(now());
        $con3 = $data->getFams()->where('user_id', $this->getId()->id)->get()->isEmpty();
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

        return empty($arr) ? $this->noticeNull() : response()->json($arr);

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
