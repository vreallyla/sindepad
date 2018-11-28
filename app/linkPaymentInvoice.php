<?php

namespace App;

use App\Model\general\dataBank;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class linkPaymentInvoice extends Model
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

    public function getBank()
    {
        return $this->belongsTo(dataBank::class,'bank_id');
    }
}
