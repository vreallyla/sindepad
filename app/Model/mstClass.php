<?php

namespace App\Model;

use App\Model\Order\Setting\rulesTimeOption;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class mstClass extends Model
{
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    public $incrementing =false ;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getRule()
    {
        return $this->hasMany(rulesTimeOption::class,'class_id');
    }
}
