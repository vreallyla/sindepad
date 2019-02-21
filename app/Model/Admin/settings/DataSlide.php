<?php

namespace App\Model\Admin\settings;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class DataSlide extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $incrementing = false;

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
}
