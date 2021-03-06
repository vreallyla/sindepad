<?php

namespace App;

use App\Model\sideGender;
use App\Model\sideLastEducation;
use App\Model\sideProfessionList;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class linkStudentFamily extends Model
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

    public function getSex()
    {
        return $this->belongsTo(sideGender::class, 'gender_id');
    }

    public function getProfession()
    {
        return $this->belongsTo(sideProfessionList::class,'profession_id');
    }

    public function getEducation()
    {
        return $this->belongsTo(sideLastEducation::class,'education_id');
    }

}
