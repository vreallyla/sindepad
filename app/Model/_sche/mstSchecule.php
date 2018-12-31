<?php

namespace App\Model\_sche;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class mstSchecule extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];
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

    public function getRs()
    {
        return $this->hasMany(rsSchecule::class,'sche_id');
    }
}
