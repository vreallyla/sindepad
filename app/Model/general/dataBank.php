<?php

namespace App\Model\general;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class dataBank extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    public $incrementing =false ;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
