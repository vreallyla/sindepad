<?php

namespace App\Model\order;

use App\linkStudentFamily;
use App\Model\rsDisability;
use App\rsStudentFamily;
use App\rsTransMultiStudent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

const types = ['fullName', 'sex', 'rs', 'needed', 'desc', 'aggrement'];
const payments = ['code', 'an', 'paying_method'];
const TYPE_CHECKOUT = [
    'confirm' => 'menunggu',
    'payment' => 'konfirmasi',
    'success' => 'berhasil',
    'failed' => 'batal',
    'waiting' => 'administrasi'
];

class expression extends Model
{

    protected $data_session = array();
    protected $payment = array();
    protected $step = 1;

//    public function __construct($data)
//    {
//        foreach (types as $i => $type) {
//            if (array_key_exists($type, $data)) {
//                foreach ($data[$type] as $z => $row) {
//                    $this->data_session[$z][$type] = $row;
//                }
//            }
//        }
//
//    }

    public function saveVoucher($code)
    {
        $this->payment['voucher'] = $code;
    }

    public static function postFamily($user, $hub, $student)
    {
        $family = linkStudentFamily::create([
            'name' => $user->name,
            'address' => $user->address,
            'gender_id' => $user->gender_id,
            'born_place' => $user->born_place,
            'dob' => $user->dob,
            'phone' => $user->phone
        ]);

        rsStudentFamily::create([
            'student_id' => $student,
            'family_id' => $family->id,
            'hub_id' => $hub,
            'user_id'=>$user->id
        ]);
    }

    public static function postNeeded($need, $student)
    {
        foreach ($need as $z) {
            rsDisability::create([
                'student_id' => $student,
                'disablity_id' => $z
            ]);
        }
    }

    public static function shortName($str)
    {
        $dis = strpos($str, ' ');
        return $dis ? substr($str, 0, $dis) : $str;
    }

    public static function postListCart($trans, $student)
    {
        $multiCart = rsTransMultiStudent::create([
            'trans_id' => $trans,
            'student_id' => $student
        ]);
        $type = linkTransPrice::where('status','active')->get();
        foreach ($type as $r)
            rsTransPrice::create([
                'trans_user_id' => $multiCart->id,
                'price_id' => $r->id
            ]);
    }

    public static function validar($r, $steps)
    {
        $data['re'] = $r->only('aggrement');
        $data['rules'] = [
            "aggrement" => 'required',
        ];

        $data['msg'] = [
            'aggrement.required' => 'Centang setuju untuk mendaftar.',
        ];


        if ($steps >= 2) {
            $data['min'] = $r->has('length') ? $r->length : "1";
            $data['re'] = $r->only('fullName', 'sex', 'packet', 'course', 'rs', 'needed', 'desc', 'time', 'aggrement');
            $data['rules'] = array_merge($data['rules'], [
                "fullName" => "required|array|min:" . $data['min'] . '|max:3',
                "sex" => "required|array|min:" . $data['min'] . '|max:3',
                "needed" => "required|array|min:" . $data['min'] . '|max:3',
                "rs" => "required|array|min:" . $data['min'] . '|max:3',
                "fullName.*" => "required|string|distinct|min:3",
                'sex.*' => 'required|exists:side_genders,id',
                'needed.*' => 'required|exists:mst_disabilities,id',
                'rs.*' => 'required|exists:mst_hubs,id',
            ]);

            $data['msg'] = array_merge($data['msg'], [
                'required' => 'Harap pilih Kolom diatas',
                'exists' => 'Harap tidak merubah data',
                'array' => 'Harap tidak merubah data',
                'in' => 'Harap tidak merubah data',
                'distinct' => 'Harap tidak memakai nama sama',
                'name.min' => 'Harap mengisi semua data nama',
                'sex.min' => 'Harap mengisi semua data j.kel',
                'needed.min' => 'Harap mengisi semua data kebutuhab',
                'rs.min' => 'Harap mengisi semua data hub.',
                'max' => 'Data maksimal 3 form',
                'fullName.*.required' => 'Harap isi Kolom diatas',
                'fullName.required' => 'Harap isi Kolom diatas',
                'fullName.*.min' => 'Harap isi kolom diatas minim 3 huruf',
            ]);
        }

        return $data;
    }


    /**
     * set request to array
     * @param $data
     * @return array
     */
    public function setSession($type)
    {
        $session = session()->has('order') ? session('order') : null;
        if ($session && array_key_exists('data', $session)) {

            $old = count($session['data']);
            $new = count($this->data_session);

            if ($old < $new) {
                foreach ($session['data'] as $i => $row) {
                    $this->data_session[$i] = array_merge($row, $this->data_session[$i]);
                }
            } else {
                foreach ($this->data_session as $i => $row) {
                    $this->data_session[$i] = array_merge($session['data'][$i], $row);
                }
                $this->data_session = array_slice($this->data_session, 0, $new, true);
            }

            if ($type == 'next') {
                $this->step += $session['step'];
            }
        }

        $this->make_session();
    }

    private function make_session()
    {
        session()->put('order', ['data' => $this->data_session, 'step' => $this->step]);
    }

    public static function personalDetaiTrans($id)
    {

    }

    public static function confirmTabCheckOut($user, $z, $r)
    {
        $array2 = [];
        foreach ($user->getTrans()->where([
            ['status', TYPE_CHECKOUT[$r->tab]],
            ['user_id', $user->id]
        ])->orderBy('updated_at', 'desc')->get() as $i => $rs_multi_order) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $rs_multi_order->updated_at);
            $total = 0;

            if ($rs_multi_order->method_id) {
                $array[$i]['method'] = $rs_multi_order->getMethod->only('name', 'url', 'method', 'desc');
            }

            foreach ($rs_multi_order->getMultiTrans as $z => $detail) {
                $name = $detail->getStudent->name;
                $array[$i]['list'][$z] = [
                    'FullName' => $name,
                    'shortName' => expression::shortName($name),
                    'bills' => [],
                    'entity' => 0,
                    'total' => 0
                ];

                foreach ($detail->getList as $x => $item) {
                    $price = $item->getPrince;
                    array_push($array[$i]['list'][$z]['bills'], $price->only('name', 'amount'));
                    $array[$i]['list'][$z]['entity'] += 1;
                    $array[$i]['list'][$z]['total'] += $price->amount;
                    $total += $price->amount;
                }
            }
            $array[$i]['total'] = $total;
            $array[$i]['entity'] = $z + 1;
            $array[$i]['id'] = $rs_multi_order->id;
            $array[$i]['status'] = $rs_multi_order->status;
            $array[$i]['end_date'] = TYPE_CHECKOUT[$r->tab] === 'menunggu' || TYPE_CHECKOUT[$r->tab] === 'konfirmasi' ?
                $date->addDays(1) : $date;

            if ($rs_multi_order->voucher_id) {
                $contentVoucher = $rs_multi_order->getVoucher;
                $array[$i]['voucher'] = [
                    'amount' => $contentVoucher->amount,
                    'type' => $contentVoucher->type
                ];
            }
            if (TYPE_CHECKOUT[$r->tab] === 'menunggu' || TYPE_CHECKOUT[$r->tab] === 'konfirmasi') {
                if (Carbon::createFromFormat('Y-m-d H:i:s', $rs_multi_order->updated_at)->addDays(1)->greaterThan(now())) {
                    array_push($array2, $array[$i]);
                }
            } else {
                array_push($array2, $array[$i]);
            }


        }
        return !empty($array2) ? response()->json($array2) : response()->json(['msg' => 'data kosong'], 403);
    }

    public static function confirmTabFailed($user, $z, $r)
    {
        $array2 = [];
        foreach ($user->getTrans()->where('user_id', $user->id)->orderBy('updated_at', 'desc')->get() as $i => $rs_multi_order) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $rs_multi_order->updated_at);
            $total = 0;
            foreach ($rs_multi_order->getMultiTrans as $z => $detail) {
                $name = $detail->getStudent->name;
                $array[$i]['list'][$z] = [
                    'FullName' => $name,
                    'shortName' => expression::shortName($name),
                    'bills' => [],
                    'entity' => 0,
                    'total' => 0
                ];
                foreach ($detail->getList as $x => $item) {
                    $price = $item->getPrince;
                    array_push($array[$i]['list'][$z]['bills'], $price->only('name', 'amount'));
                    $array[$i]['list'][$z]['entity'] += 1;
                    $array[$i]['list'][$z]['total'] += $price->amount;
                    $total += $price->amount;
                }
            }
            $array[$i]['total'] = $total;
            $array[$i]['entity'] = $z + 1;
            $array[$i]['id'] = $rs_multi_order->id;
            $array[$i]['status'] = $rs_multi_order->status;
            $array[$i]['end_date'] = TYPE_CHECKOUT[$r->tab] === 'menunggu' || TYPE_CHECKOUT[$r->tab] === 'konfirmasi' || TYPE_CHECKOUT[$r->tab] === 'batal' ?
                $date->addDays(1) : $date;

            if ($rs_multi_order->voucher_id) {
                $contentVoucher = $rs_multi_order->getVoucher;
                $array[$i]['voucher'] = [
                    'amount' => $contentVoucher->amount,
                    'type' => $contentVoucher->type
                ];
            }
            if ($rs_multi_order->status === 'batal') {
                array_push($array2, $array[$i]);
            } elseif ($rs_multi_order->status === 'menunggu' || $rs_multi_order->status === 'konfirmasi') {
                if (!Carbon::createFromFormat('Y-m-d H:i:s', $rs_multi_order->updated_at)->addDays(1)->greaterThan(now())) {
                    array_push($array2, $array[$i]);
                }
            }
        }
        return !empty($array2) ? response()->json($array2) : response()->json(['msg' => 'data kosong'], 403);
    }
}
