<?php

namespace App\Model;

use App\Model\_sche\mstSchecule;
use App\Model\_student\dataScoreResult;
use App\mstEvaluation;
use App\mstHub;
use App\rsStudentFamily;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Webpatser\Uuid\Uuid;

class linkUserStudent extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $incrementing = false;
    protected $appends = [
        'date_active'
    ];

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

    public static function Chekparent($id, $key)
    {
        return linkUserStudent::find($id)->getFams()->where('user_id', $key)->get();
    }

    public static function detailN($id)
    {
        $data = linkUserStudent::find($id);
        $needed = $data->getDisablity()->orderBy('created_at', 'asc')->pluck('disablity_id');

        return array_merge($data->only('born_place', 'dob', 'phone', 'address', 'detail', 'name','detail'), [
            'key' => $data->id,
            'code_regist' => $data->ni,
            'img' => File::exists($data->url) ? asset($data->url) : asset('images/img_unvailable.png'),
            'needed' => [
                'data' => mstDisability::orderBy('name', 'asc')->get(['id', 'name']),
                'selected' => $needed
            ],
            'rel' => [
                'data' => mstHub::orderBy('created_at', 'asc')->get(['id', 'ind'])
            ],
            'gender' => [
                'data' => sideGender::orderBy('created_at', 'asc')->get(['id', 'ind']),
                'selected' => $data->gender_id
            ]
            , 'date_exp' => Carbon::parse($data->register)->addMonth()->toDateString()
        ]);
    }

    public function getDateActiveAttribute()
    {
        return Carbon::parse($this->attributes['register'])->addMonth()->gt(now()) ?
            [
                'ind' => 'Aktif',
                'en' => 'Active',
                'a' => Carbon::parse($this->attributes['register'])->gt(now())
            ] : [
                'ind' => 'Non Aktif',
                'en' => 'Expired',
                'a' => Carbon::parse($this->attributes['register']),
                'b' => now()
            ];
    }

    public function getUserMany()
    {
        return $this->belongsToMany(User::class,
            'rs_user_to_students', 'student_id', 'user_id');
    }

    public function getEvaMany()
    {
        return $this->belongsToMany(mstEvaluation::class,
            'rs_evaluations', 'student_id', 'eva_id');
    }


    public function getClass()
    {
        return $this->belongsTo(mstClass::class, 'class_id');
    }

    public function getDisablity()
    {
        return $this->hasMany(rsDisability::class, 'student_id');
    }

    public function getDisablityMany()
    {
        return $this->belongsToMany(mstDisability::class, 'rs_disabilities', 'student_id', 'disablity_id');
    }

    public function getFams()
    {
        return $this->hasMany(rsStudentFamily::class, 'student_id');
    }

    public function getSex()
    {
        return $this->belongsTo(sideGender::class, 'gender_id');
    }

    public function getSche()
    {
        return $this->belongsTo(mstSchecule::class, 'sche_id');
    }

    public function getShadow()
    {
        return $this->hasMany(rsHomeroom::class, 'student_id');
    }

    public function getScore()
    {
        return $this->hasMany(dataScoreResult::class, 'student_id');
    }
}
