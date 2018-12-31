<?php

namespace App\Model\_activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class sideActivity extends Model
{

    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at','deleted_at'];
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

    public function getMstAct()
    {
        return $this->belongsTo(mstActivity::class,'mst_id');
    }
    public function getMstActwithTrash()
    {
        return $this->belongsTo(mstActivity::class,'mst_id')->withTrashed();
    }

}
