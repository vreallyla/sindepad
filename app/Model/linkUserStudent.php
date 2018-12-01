<?php

namespace App\Model;

use App\rsStudentFamily;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class linkUserStudent extends Model
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
    public function getClass()
    {
        return $this->belongsTo(mstClass::class, 'class_id');
    }

    public function getDisablity()
    {
        return $this->hasMany(rsDisability::class,'student_id');
    }

    public function getFams()
    {
        return $this->hasMany(rsStudentFamily::class,'student_id');
    }

    public function getSex()
    {
        return $this->belongsTo(sideGender::class,'gender_id');
    }
}
