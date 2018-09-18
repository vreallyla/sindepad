<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class mstFeedback extends Model
{
    protected $guarded = ['user_id','created_at','updated_at'];
    public $incrementing =false ;

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_id = (string) Uuid::generate(4);
        });
    }
}
