<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsHomeroom extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    public $incrementing =false ;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getStud()
    {
        return $this->belongsTo(linkUserStudent::class,'student_id');
    }

    public function getTeacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}
