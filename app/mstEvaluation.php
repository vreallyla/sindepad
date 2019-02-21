<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class mstEvaluation extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $incrementing = false;
    protected $hidden=[
      'id','date_for','pivot','date'
    ];
   protected $appends=[
      'key','date'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }

    public function getKeyAttribute()
    {
        return$this->attributes['id'];
    }
    public function getDateAttribute()
    {
        return$this->attributes['date_for'];
    }

}
