<?php

namespace App\Http\Controllers\Api\Shadow;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class chartController extends Controller
{

    use extraClass;

    public function getGraph(Request $r)
    {

        if ($er = $this->valD($r)) {
            return $er;
        }


        if ($this->getId()->getRsHomerooms()->where('student_id', $r->key)->get()->isEmpty()) {
            return response()->json(['key' => 'data tidak ditemukan'], 422);
        }

        return $this->findData($r);

    }

    public function getFromParent(Request $r)
    {
        if ($er = $this->valD($r)) {
            return $er;
        }

        if ($this->getId()->getRsStudent()->where('student_id', $r->key)->get()->isEmpty()) {
            return response()->json(['key' => 'data tidak ditemukan'], 422);
        }

        return $this->findData($r);
    }

    private function valD($r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:link_user_students,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'Data tidak ada'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function findData($r)
    {
        $a = now();
        $day = $a->copy()->formatLocalized('%A');
        $dateNow = $a->copy()->subMonths(3)->toDateString();
        $student = linkUserStudent::find($r->key);
        $sche = $student->getSche ? $student->getSche->getRs : [];
        $ar = [];
        $acts = [];


        if (empty($student->where('status', 'Active')->whereDate('register', '>=', $a->copy()->subMonths(1))->first())) {
            return response()->json(['key' => 'peserta didik dalam masa tenggang'], 422);
        }
        foreach ($sche as $row) {

            if ($row->getDay->en === $day && !is_null($row->sche_id) && !is_null($row->getActivitywithTrash)) {

                $acts[] = $row->getActivitywithTrash->only('id', 'name');
            }
        }

        foreach ($student->getScore()->orderBy('date', 'asc')->whereDate('date', '>=', $dateNow)->get() as $z => $score) {
            if (Carbon::parse($score->date)->formatLocalized('%A') === $day) {

                foreach ($acts as $i => $act) {

                    if ($act['id'] === $score->getSubActwithTrash->getMstActwithTrash->id) {
                        $ar[$act['name']][] = array_merge($score->only('value', 'achievement', 'note', 'date'), [
                            'activity_sub' => $score->getSubAct ? $score->getSubAct->name : 'belum diisi'
                        ]);
                    }

                }
            }
        }

        $objAr = key($ar);
        $check = 0;
        foreach ($ar as $i => $row) {
            if ($check <= count($row)) {
                $check = count($row);
                $objAr = $i;
            }
        }

        $arr['name'] = $student->name;
        $arr['act_label'] = array_column($acts, 'name');
        $arr['date_label'] = $objAr ? array_column($ar[$objAr], 'date') : [];


        foreach (array_keys($ar) as $key) {
            $b[] = 1;
            for ($i = 0; $i < count($arr['date_label']); $i++) {

                if (!empty($ar[$key][$i])) {
                    $subAr = $ar[$key];

//                    return $ar[$key][$i]['date'];
                    if ($ar[$key][$i]['date'] !== $arr['date_label'][$i]) {
                        $subAr = array_slice($subAr, 0, ($i), true);
                        array_push($subAr, [
                            'value' => 0,
                            'achievement' => 'belum diisi',
                            'note' => 'belum diisi',
                            'date' => $arr['date_label'][$i]
                        ]);
                        foreach (array_slice($ar[$key], $i, count($ar[$key]) - $i, true) as $row) {
                            array_push($subAr, $row);

                        }
                        $ar[$key] = $subAr;
                    }
                } else {
                    array_push($ar[$key], [
                        'value' => 0,
                        'achievement' => 'belum diisi',
                        'note' => 'belum diisi',
                        'date' => $arr['date_label'][$i]
                    ]);
                }
            }
        }

        $arr['list'] = $ar;
        foreach ($arr['list'] as $i => $row) {
            $objVal = array_column($row, 'value');
            $arr['max'][$i] = $arr['list'][$i][array_keys($objVal, max($objVal))[0]];
            $arr['min'][$i] = $arr['list'][$i][array_keys($objVal, min($objVal))[0]];
            $arr['last_score'][$i] = count($row) > 0 ? $row[count($row) - 1] : 0;
        }

        return response()->json($arr);
    }
}
