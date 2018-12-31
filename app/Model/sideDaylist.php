<?php

namespace App\Model;

use App\Model\_sche\rsSchecule;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class sideDaylist extends Model
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

    public function rsSchedules()
    {
        return $this->hasMany(rsSchecule::class,'day_id');
    }

}
