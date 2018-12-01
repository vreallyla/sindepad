<?php

namespace App;

use App\Model\mstTransactionList;
use App\Model\rsHomeroom;
use App\Model\sideGender;
use App\Model\sideStatusUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
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
}
