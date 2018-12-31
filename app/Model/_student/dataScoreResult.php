<?php

namespace App\Model\_student;

use App\Model\_activities\sideActivity;
use App\Model\linkUserStudent;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class dataScoreResult extends Model
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

    public function getSubAct()
    {
        return $this->belongsTo(sideActivity::class,'sd_act_id');
    }
    public function getSubActwithTrash()
    {
        return $this->belongsTo(sideActivity::class,'sd_act_id')->withTrashed();
    }
    public function getStudent()
    {
        return $this->belongsTo(linkUserStudent::class,'student_id');
    }

    public function getTeacher()
    {
        return $this->belongsTo(linkUserStudent::class,'teacher_id');
    }
}
