<?php

namespace App\Model\_activities;

use App\Model\_sche\rsSchecule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class mstActivity extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];
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

    public function getSubAct()
    {
        return $this->hasMany(sideActivity::class,'mst_id');
    }

    public function getRs()
    {
        return $this->hasMany(rsSchecule::class,'mst_id');
    }

}
