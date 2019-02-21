<?php

namespace App\Model;

use App\linkPaymentInvoice;
use App\Model\order\payingMethod;
use App\Model\order\voucherRegister;
use App\rsTransMultiStudent;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class mstTransactionList extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    public $incrementing =false ;

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getMultiTrans()
    {
        return $this->hasMany(rsTransMultiStudent::class,'trans_id');
    }

    public function getInvoice()
    {
        return $this->hasOne(linkPaymentInvoice::class,'tran_id');
    }

    public function getMethod()
    {
        return $this->belongsTo(payingMethod::class,'method_id');
    }

    public function getMethodTranshTo()
    {
        return $this->belongsTo(payingMethod::class,'method_id')->withTrashed();
    }


    public function getVoucher()
    {
        return $this->belongsTo(voucherRegister::class,'voucher_id');
    }

    public static function getStatus(){
        $type = DB::select(DB::raw('SHOW COLUMNS FROM mst_transaction_lists WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');

    }

    public function checkStatus()
    {
        return $this->belongsTo(linkPaymentInvoice::class,'tran_id');
    }
}
