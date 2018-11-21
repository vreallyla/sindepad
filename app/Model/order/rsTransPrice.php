<?php

namespace App\Model\order;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsTransPrice extends Model
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

    public function getPrince()
    {
        return $this->belongsTo(linkTransPrice::class,'price_id','id');
    }
}
