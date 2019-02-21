<?php

namespace App;

use App\Model\linkUserStudent;
use App\Model\linkUserTeacher;
use App\Model\mstTransactionList;
use App\Model\rsHomeroom;
use App\Model\sideGender;
use App\Model\sideStatusUser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Webpatser\Uuid\Uuid;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getReligion()
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "religion"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }
        return $values;
    }

    static function convertToObject($array)
    {
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    public function verification()
    {
        return $this->hasOne('App\verifyUser');
    }

    public function getTrans()
    {
        return $this->hasMany(mstTransactionList::class, 'user_id');
    }

    public function getStatus()
    {
        return $this->belongsTo(sideStatusUser::class, 'status_id');
    }

    public function getSex()
    {
        return $this->belongsTo(sideGender::class, 'gender_id');
    }

    public function getRsStudent()
    {
        return $this->hasMany(rsStudentFamily::class, 'user_id');
    }

    public function getRsHomerooms()
    {
        return $this->hasMany(rsHomeroom::class, 'teacher_id');
    }

    public function getTeacher()
    {
        return $this->hasOne(linkUserTeacher::class, 'user_id');
    }
    public function getStudentMany()
    {
        return $this->belongsToMany(linkUserStudent::class,
            'rs_user_to_students','user_id','student_id');
    }

    public static function getStudentN($query)
    {
        $ar = array();
        foreach ($query->getRsStudent()->orderBy('created_at', 'desc')->get() as $row) {
            $student = $row->getStudent;
            if ($student->status === 'Active') {
                $ar[] = self::convertToObject([
                    'key' => $student->id,
                    'name' => $student->name,
                    'status'=>self::convertToObject($student->date_active),
                    'date_exp'=>Carbon::parse($student->register)->addMonth(),
                    'code_regist'=>$student->ni,
                    'img'=>File::exists($student->url) ? asset($student->url) : asset('images/img_unvailable.png')
                ]);
            }
        }
        return $ar;
    }

}
