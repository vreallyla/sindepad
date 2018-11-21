<?php

namespace App;

use App\Model\linkUserStudent;
use App\Model\order\rsTransPrice;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsTransMultiStudent extends Model
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

    public function getStudent()
    {
        return $this->belongsTo(linkUserStudent::class,'student_id');
    }

    public function getList()
    {
        return $this->hasMany(rsTransPrice::class,'trans_user_id');
    }
}
