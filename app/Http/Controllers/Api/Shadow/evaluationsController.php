<?php

namespace App\Http\Controllers\Api\Shadow;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\mstEvaluation;
use App\rsEvaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class evaluationsController extends Controller
{

    use extraClass;

    public function desc(Request $r)
    {
        setlocale(LC_TIME, 'id');
        $re = $r->only('key', 'date');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
            'date' => 'required|date_format:"m-Y"'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data',
            'date_format' => 'harap tidak merubah format'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $kid = linkUserStudent::find($r->key);
        $dateKid = Carbon::parse(Carbon::parse($kid->created_at)->addMonth()->format('Y-m')
            . Carbon::parse($kid->register)->addMonth()->format('-d'));
        $date = Carbon::parse($dateKid->copy()->format('d-') . $r->date);
        $range = $dateKid->copy()->diffInMonths(now());
        $dateList = [];


        foreach (range(0, $range + 1) as $row) {
            $dateChange = $dateKid->copy()->addMonths($row);
            $dateList[] = [
                'key' => $dateChange->copy()->format('m-Y'),
                'name' => $dateChange->formatLocalized('%B %Y')
            ];
        }

        $dateN = ['list' => $dateList, 'selected' => $r->date];
        if (!$kid->sche_id) {
            return response()->json(['msg' => 'Harap atur jadwal dulu', 'date' => $dateN], 403);

        } elseif ($date->copy()->lt($dateKid)) {
            return response()->json(['msg' => 'Tanggal evaluasi tidak ada', 'date' => $dateN], 403);
        } elseif ($date->copy()->gt(now())) {
            return response()->json(['msg' => 'Tanggal evaluasi ' . $date->copy()->formatLocalized('%A, %d %B %Y'), 'date' => $dateN], 403);

        } elseif (Carbon::parse($kid->register)->addMonth()->addDay()->lt(now())) {
            return response()->json(['msg' => 'Peserta didik dalam masa administrasi', 'date' => $dateN], 403);
        } elseif ($kid->getShadow()->where('teacher_id', $this->getId()->id)->get()->isEmpty()) {
            return response()->json(['msg' => 'Kamu tidak memiliki Akses', 'date' => $dateN], 401);

        }

        return response()->json([
            'data' => $kid->getEvaMany()->where('date_for', $date->toDateString())->orderBy('created_at', 'desc')->first(),
            'date' => $dateN
        ]);
    }

    public function sendPost(Request $r)
    {

        setlocale(LC_TIME, 'id');
        $re = $r->only('key', 'date', 'key_eva', 'detail');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
            'key_eva' => $r->key_eva ? 'required|exists:mst_evaluations,id' : '',
            'date' => 'required|date_format:"m-Y"',
            'detail' => 'required'
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Harap tidak merubah data',
            'date_format' => 'harap tidak merubah format'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }


        $kid = linkUserStudent::find($r->key);
        $dateKid = Carbon::parse(Carbon::parse($kid->created_at)->addMonth()->format('Y-m')
            . Carbon::parse($kid->register)->addMonth()->format('-d'));
        $date = Carbon::parse($dateKid->copy()->format('d-') . $r->date);
        $range = $dateKid->copy()->diffInMonths(now());

        if ($date->copy()->lt($dateKid)) {
            return response()->json(['msg' => 'Tanggal evaluasi tidak ada'], 403);
        } elseif ($date->copy()->gt(now())) {
            return response()->json(['msg' => 'Tanggal evaluasi ' . $date->copy()->formatLocalized('%A, %d %B %Y')], 403);

        } elseif (Carbon::parse($kid->register)->addMonth()->lt(now())) {
            return response()->json(['msg' => 'Peserta didik dalam masa administrasi'], 403);
        } elseif ($kid->getShadow()->where('teacher_id', $this->getId()->id)->get()->isEmpty()) {
            return response()->json(['msg' => 'Kamu tidak memiliki Akses'], 401);
        }

        try {
            if ($r->key_eva) {
                mstEvaluation::find($r->key_eva)->update($r->only('detail'));
            } else {
                $sva = mstEvaluation::create([
                    'detail' => $r->detail,
                    'date_for' => $date->toDateString()
                ]);

                rsEvaluation::create([
                    'student_id' => $r->key,
                    'eva_id' => $sva->id
                ]);
            }

            return $this->noticeSuc();
        } catch (\Exception $er) {
            return $this->noticeFail();
        }

    }
}
