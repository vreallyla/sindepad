<?php

namespace App\Model\_sche;

use App\Model\_activities\mstActivity;
use App\Model\sideDaylist;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsSchecule extends Model
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

    public function getActivity()
    {
        return $this->belongsTo(mstActivity::class,'mst_id');
    }
    public function getActivitywithTrash()
    {
        return $this->belongsTo(mstActivity::class,'mst_id')->withTrashed();
    }
    public function getDay()
    {
        return $this->belongsTo(sideDaylist::class,'day_id');
    }
}
