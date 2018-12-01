<?php

namespace App\Http\Controllers\Api\Admin\Trans;

use App\DeclaredPDO\Jwt\extraClass;
use App\Mail\noticeNewUserMail;
use App\Model\linkUserStudent;
use App\Model\mstTransactionList;
use App\Model\order\expression;
use App\User;
use App\verifyUser;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DeclaredPDO\Admin\Transaction\trans_get;
use Illuminate\Support\Facades\Mail;

const DATA_CAT = ['cop' => 'konfirmasi', 'tf' => 'administrasi'];
const TYPE_USER = ['Admin', 'Pengajar', 'User', 'Peserta Didik', 'Hub'];


class orderSignController extends Controller
{
    use extraClass;

    public function create(Request $r)
    {

        $re = $r->only('nameUser', 'genderUser', 'nameStudent', 'genderStudent', 'email', 'needed', 'rs');
        $rule = [
            'nameUser' => 'required|min:3',
            'genderUser' => 'required|exists:side_genders,id',
            'nameStudent' => 'required|min:3',
            'genderStudent' => 'required|exists:side_genders,id',
            'email' => 'required|string|email|max:255|unique:users',
            "needed" => 'required|array|min:1',
            'needed.*' => 'required|exists:mst_disabilities,id',
            'rs' => 'required|exists:mst_hubs,id',
        ];
        $msg = [
            'required' => 'Harap isi kolom diatas',
            'exist' => 'Harap tidak merubah data',
            'unique' => 'email sudah dipakai',
            'nameStudent.min' => 'isi minimal 3 huruf',
            'nameUser.min' => 'isi minimal 3 huruf',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $pass = str_random(12);

        if (!$status = $this->getUserStatus(TYPE_USER[2])) {
            return $this->noticechangeData();
        }

        $user = User::create([
            'name' => $r->nameUser,
            'gender_id' => $r->genderUser,
            'email' => $r->email,
            'password' => bcrypt($pass),
            'code_status' => bcrypt(false),
            'status_id' => $status,
            'url' => 'images/img_unvailable.png',
            'ni' => $this->niSet(new User(), (3))

        ]);
        $verify = verifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(45)
        ]);

        try {
            Mail::to($r->email)->send(new noticeNewUserMail([
                'role' => 'User',
                'password' => $pass,
                'email' => $r->email,
                'name' => $r->nameUser,
                'code' => $verify->token
            ]));
        } catch (\Exception $e) {
            verifyUser::find($verify->id)->delete();
            User::find($user->id)->forceDelete();
            return $this->noticeFail();
        }
        $this->addStudentTrans($user, $r);
        return $this->noticeSuc();
    }

    private function addStudentTrans($user, $r)
    {
        $transaction = mstTransactionList::create([
            'user_id' => $user->id,
            'status' => 'berhasil',
            'code' => 'SG' . now()->format('ymd') . sprintf("%04d", (count(mstTransactionList::whereDate('created_at', '=', now()->format('Y-m-d'))->get()) + 1)) . 'PK'
        ]);

        $student = linkUserStudent::create([
            'name' => $r->nameStudent,
            'gender_id' => $r->genderStudent,
            'detail' => $r->desc,
            'status' => 'Active',
            'ni' => $this->niSet(new User(), 4),
            'register' => now()->toDateString()]);

        expression::postNeeded($r->needed, $student->id);
        expression::postListCart($transaction->id, $student->id);
        expression::postFamily($user, $r->rs, $student->id);
    }

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

        return $this->setPaginate($arr, $r->row, $r->page);
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
