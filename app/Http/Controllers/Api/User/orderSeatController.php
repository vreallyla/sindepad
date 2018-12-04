<?php

namespace App\Http\Controllers\Api\User;

use App\DeclaredPDO\Jwt\extraClass;
use App\linkPaymentInvoice;
use App\Model\linkUserStudent;
use App\Model\mstTransactionList;
use App\Model\order\expression;
use App\Model\order\voucherRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image; //Intervention Image
use Illuminate\Support\Facades\Storage;


class orderSeatController extends Controller
{
    use extraClass;

    protected $batch;

    public function overwriteCheck(Request $r)
    {
        $data = expression::validar($r, $r->indexForm + 1);

        if ($error = self::validates($data['re'], $data['rules'], $data['msg'])) {
            return $error;
        }

        return response()->json(['msg' => 'validate complete'], 200);
    }

    public function overwrite(Request $r)
    {
        $data = expression::validar($r, $r->indexForm + 1);

        if ($error = self::validates($data['re'], $data['rules'], $data['msg'])) {
            return $error;
        }

        $user = $this->getId();
        $transaction = mstTransactionList::create([
            'user_id' => $user->id,
            'status' => 'menunggu',
            'code' => 'SG' . now()->format('ymd') . sprintf("%04d", (count(mstTransactionList::whereDate('created_at', '=', now()->format('Y-m-d'))->get()) + 1)) . 'PK'
        ]);

        foreach ($r->fullName as $i => $row) {
            $student = linkUserStudent::create([
                'name' => $row,
                'gender_id' => $r->sex[$i],
                'detail' => $r->desc[$i],
                'status' => 'Non Active'
            ]);

            expression::postNeeded($r->needed[$i], $student->id);
            expression::postListCart($transaction->id, $student->id);
            expression::postFamily($user, $r->rs[$i], $student->id);
        }


        return response()->json(['msg' => 'Pendaftaran Berhasil'], 200);
    }

    public function seeCheckout(Request $r)
    {

        if ($r->has('tab')) {
            if ($r->tab === 'confirm' || $r->tab === 'payment' || $r->tab === 'success' || $r->tab === 'waiting') {
                $array = expression::confirmTabCheckOut($this->getId(), 0, $r);

            } elseif ($r->tab === 'failed') {
                $array = expression::confirmTabFailed($this->getId(), 0, $r);
            } else {
                $array = $this->noticechangeData();
            }
            return $array;
        } else {
            return $this->noticechangeData();
        }
    }

    public function confirmPayment(Request $r)
    {
        $re = $r->only('img_', 'date', 'name', 'bank', 'q');
        $rule = [
            'img_' => 'required|image|max:6000',
            'date' => 'required|date',
            'name' => 'required|min:3',
            'bank' => 'required|exists:data_banks,id',
            'q' => 'required|exists:mst_transaction_lists,id'
        ];
        $msg = [
            'required' => 'harap isi form',
            'img_.image' => 'format harus photo',
//            'img_.max' => 'photo maksimal 1500 KB',
            'exists' => 'harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        $time = now();
        $new = $r->file('img_');

        if ($img = $r->hasFile('img_')) {
            $name = $time->format('Y_m_d_H_i_s_u') . str_random(15) . '.' . $r->img_->getClientOriginalExtension();
        }

        if ($new->isValid()) {
            $name = Storage::disk('local')->put('public/order/invoice', $new);
            $url = self::slice_public($name);

            $thumbnailpath = $url;

            $img = Image::make($thumbnailpath)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 100)->save($thumbnailpath);

            if (!file_exists($url)) {
                return response()->json(['msg' => 'upload gambar gagal'], 400);
            }
//

            $anu=linkPaymentInvoice::create([
                'img' => $url,
                'name' => $r->name,
                'date_send' => $r->date,
                'bank_id' => $r->bank,
                'tran_id' => $r->q
            ]);

//
            mstTransactionList::findOrFail($r->q)->update([
                'status' => 'administrasi'
            ]);

            return $this->noticeSuc();
        }

        return $this->noticeFail();
    }

    public function confirmPost(Request $r)
    {
        $re = $r->only('trans', 'met', 'disc');
        $trans = $r->trans;
        $cout = count($trans);
        $rules = [
            'trans' => 'required|array|min:1',
            'trans.*' => 'required|exists:mst_transaction_lists,id',
            'met' => 'required|exists:paying_methods,id',
            'disc' => 'exists:voucher_registers,id'];
        $msg = [
            'required' => 'Harap tidak merubah data',
            'exists' => 'Harap tidak merubah data',
            'min' => 'Harap tidak merubah data',
            'array' => 'Harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return $error;
        }

        for ($i = 1; $i < $cout; $i++) {
            $objTrans = mstTransactionList::findOrFail($trans[$i]);
            foreach ($objTrans->getMultiTrans as $row) {
                $row->update([
                    'trans_id' => $trans[0]
                ]);
            }
            $objTrans->delete();
        }

        mstTransactionList::findOrFail($trans[0])->update([
            'status' => 'konfirmasi',
            'voucher_id' => $r->disc ? $r->disc : null,
            'method_id' => $r->met
        ]);

        return response()->json(['msg' => 'Konfirmasi Berhasil'], 200);
    }

    public function transDelete(Request $r)
    {
        try{
            mstTransactionList::findOrFail($r->q)->update([
               'status'=>'batal'
            ]);
        }catch (\Exception $e){
            return $this->notFound();
        }

        return response()->json('transaksi berhasil dihapus');
    }

    public function methodChange(Request $r)
    {
        $re = $r->only('choice');
        $rules = [
            'choice' => 'required|exists:paying_methods,id',
//            'q' => 'required|exists:mst_transaction_lists,id',
        ];
        $msg = [
            'required' => 'Harap tidak merubah data',
            'exists' => 'Harap tidak merubah data',
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return $error;
        }

        mstTransactionList::find($r->q)->update([
            'method_id' => $r->choice
        ]);

        return response()->json(['msg'=>'metode berhasil diganti'],200);
    }

    public function checkCode(Request $request)
    {

        $re = $request->only('code');
        $rules = ['code' => 'required|exists:voucher_registers,code'];
        $msg = [
            'required' => 'isi kolom diatas untuk peng.voucher',
            'exists' => 'Voucher tidak terdaftar'
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return $error;
        }

        if (!$validDate = voucherRegister::where('code', $request->code)->whereDate('expired', '>', now()->toDateString())->first()) {
            return response()->json(['code' => 'Voucher sudah tidak bisa dipakai.'], 422);
        }

        return response()->json([
            'type' => $validDate->type,
            'amount' => $validDate->amount,
            'id' => voucherRegister::where('code', $request->code)->first()->id
        ]);
    }


}
