<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsUserToStudent extends Model
{
    protected $fillable = ['student_id','user_id'];
    public $incrementing =false ;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getStudent()
    {
        return $this->belongsTo(linkUserStudent::class, 'student_id');
    }
}
