<?php

namespace App\Http\Controllers\Api\Admin\Trans;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\mstTransactionList;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DeclaredPDO\Transaction\trans_get;

const DATA_CAT = ['cop' => 'konfirmasi', 'tf' => 'administrasi'];

class orderSignController extends Controller
{
    use extraClass;

    public function getList(Request $r)
    {
        $re = $r->only('cat', 'row', 'page');
        $rule = [
            'cat' => 'required|in:tf,cop',
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

        $trans = mstTransactionList::query();
        $trans->when($r->cat === 'tf', function ($q, $cat) {
            return $q->where('status', 'administrasi');
        });
        $trans->when($r->cat === 'cop', function ($q, $cat) {
            return $q->where('status', 'konfirmasi')->wherehas('getMethod', function ($met) {
                $met->where('method', 'Bayar Ditempat');
            });
        });
        foreach ($trans->orderBy('updated_at', 'desc')->get() as $row) {
            $getTrans = new trans_get($row);
            $arr[] = $getTrans->get_tf();
        }

        if ($r->q) {
            $arr = trans_get::searchSome($arr, $r->q);
        }

        return trans_get::setPaginate($arr, $r->row, $r->page);
    }

    public function getDetail(Request $r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:mst_transaction_lists,id'
        ];
        $msg = [
            'required' => 'Harap isi Kolom',
            'exists' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        try {
            $model = mstTransactionList::findOrFail($r->key);
        } catch (\Exception $e) {
            return $this->notFound();
        }

        $trans_detail = new trans_get($model);

        return $trans_detail->detail_tf();
    }

    public function postConfirm(Request $r)
    {
        $re = $r->only('key');
        $rule = [
            'key' => 'required|exists:mst_transaction_lists,id'
        ];
        $msg = [
            'required' => 'Harap isi Kolom',
            'exists' => 'Harap tidak merubah data'
        ];


        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        try {
            $model = mstTransactionList::findOrFail($r->key);
        } catch (\Exception $e) {
            return $this->notFound();
        }

        $trans = new trans_get($model);
        return $model->status === 'administrasi' ?
            $trans->confirmTrans() :
            ($model->status === 'konfirmasi' ?
                $trans->checkConfirm() :
                $this->notFound());

    }


}
