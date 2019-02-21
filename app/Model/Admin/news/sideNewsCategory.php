<?php

namespace App\Model\Admin\news;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class sideNewsCategory extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
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

    public function getRs()
    {
        return $this->hasMany(RsNews::class,'category_id');
    }

}
