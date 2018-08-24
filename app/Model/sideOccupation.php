<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


class sideOccupation extends Model
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
}
