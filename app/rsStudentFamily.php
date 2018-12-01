<?php

namespace App;

use App\Model\linkUserStudent;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsStudentFamily extends Model
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

    public function getFami()
    {
    return $this->belongsTo(linkStudentFamily::class,'family_id');
    }
    public function get_hub()
    {
    return $this->belongsTo(mstHub::class,'hub_id');
    }

    public function getStudent()
    {
        return $this->belongsTo(linkUserStudent::class,'student_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
