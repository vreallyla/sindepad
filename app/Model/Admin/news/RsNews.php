<?php

namespace App\Model\Admin\news;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class RsNews extends Model
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

    public function getMst()
    {
        return $this->belongsTo(MstNewsList::class,'mst_id');
    }
    public function getSide()
    {
        return $this->belongsTo(sideNewsCategory::class,'category_id');
    }

}
