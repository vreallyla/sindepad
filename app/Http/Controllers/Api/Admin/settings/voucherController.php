<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Jwt\extraClass;
use App\DeclaredPDO\response;
use App\Model\order\voucherRegister;
use function GuzzleHttp\Psr7\try_fopen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

const REBATE = [
    'percent' => 'Diskon',
    'cash' => 'Potong Harga'
];

class voucherController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        if ($er = $this->valPaginateWithCat($r, [10, 30, 50], ['percent', 'cash'])) {
            return $er;
        }

        $data = voucherRegister::when($r->cat, function ($query) use ($r) {
            return $query->where('type', REBATE[$r->cat]);
        })->when($r->q, function ($query) use ($r) {
            return $query->where('code', 'LIKE', '%' . $r->q . '%')->orWhere('expired', 'LIKE', '%' . $r->q . '%')
                ->orWhere('amount', 'LIKE', '%' . $r->q . '%');

        })->orderBy('created_at', 'desc')/*->select('code','expired')*/
        ->paginate($r->row);

        return $data->isEmpty() ? $this->noticeNull() : response()->json($data);
    }

    public function setDel(Request $r)
    {
        if ($er = $this->valID($r)) {
            return $er;
        }

        try {
            voucherRegister::destroy($r->key);
            return $this->noticeDelSuc();
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

    }


    public function setUpdate(Request $r)
    {
        if ($er = $this->valPost($r)) {
            return $er;
        }
        try {
            voucherRegister::find($r->key)->update([
                'code' => $r->voucher,
                'expired' => $r->expired,
                'amount' => $r->amount,
                'type' => $r->has('con') ?
                    'Diskon'
                    : 'Potong Harga'
                ,
            ]);

            return $this->noticeEditSuc();
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

    }

    public function sendPost(Request $r)
    {
//        return $r;
        if ($er = $this->valPost($r)) {
            return $er;
        }
        $type = $r->has('con') ?
            'Diskon'
            : 'Potong Harga';
        try {
            voucherRegister::create([
                'code' => $r->voucher,
                'expired' => $r->expired,
                'amount' => $r->amount,
                'type' => $type
                ,
            ]);
            return $this->noticeSuc();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getEdit(Request $r)
    {
        if ($er = $this->valID($r)) {
            return $er;
        }

        try {
            return voucherRegister::find($r->key);
        } catch (\Exception $e) {
            return $this->noticeFail();
        }
    }

    private function valPost($r)
    {
        $re = $r->only('expired', 'amount', 'voucher');
        $rule = [
            'expired' => 'required|date_format:Y-m-d',
            'voucher' => 'required|regex:/^\S*$/u|unique:voucher_registers,code',
            'amount' => 'required|numeric' . ($r->has('con') ? '|min:1|max:100' : ''),
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'date_format' => 'Format tanggal tahun-bulan-hari',
            'numeric' => 'Harap isi dengan angka',
            'min' => 'isi minimal 1%',
            'max' => 'isi maksimal 100%',
            'exists' => 'data tidak ditemukan',
            'regex' => 'Harap tidak menggunakan spasi',
            'unique'=>'kode voucher telah digunakan'
        ];

        if ($r->has('key')) {
            $re['key'] = $r->key;
            $rule['key'] = 'required|exists:voucher_registers,id';
        }

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

    private function valID($r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:voucher_registers,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom',
            'exists' => 'data tidak ditemukan',
        ];
        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }
    }

}
