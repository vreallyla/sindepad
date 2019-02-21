<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\order\linkTransPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class priceController extends Controller
{
    use extraClass;

    public function getList()
    {
        return linkTransPrice::where('status', 'active')->orderBy('name', 'asc')->select('id', 'name', 'amount')->get();
    }

    public function Sendupdate(Request $r)
    {
        $re = $r->only('key', 'amount');
        $rule = [
            'key' => 'required|exists:link_trans_prices,id',
            'amount' => 'required',
        ];
        $msg = [
            'required' => 'Harap isi kolom diatas',
            'exist' => 'Data tidak ditemukan',
        ];

        if ($error = self::validates($re, $rule, $msg)) {
            return $error;
        }

        try {
            $data = linkTransPrice::find($r->key);
            $target = linkTransPrice::where('amount', $r->amount)->first();

            linkTransPrice::where('name', $data->name)->update([
                'status' => 'non active'
            ]);

            if ($target) {
                $target->update([
                    'status' => 'active'
                ]);
            } else {
                linkTransPrice::create([
                    'name' => $data->name,
                    'amount' => $r->amount,
                    'status'=>'active'
                ]);
            }
        } catch (\Exception $e) {
            return $this->noticeFail();
        }

        return $this->noticeEditSuc();
    }

}
