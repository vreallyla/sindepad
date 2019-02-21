<?php

namespace App\Model\Peng;

use App\DeclaredPDO\response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

const STATS_DECODE_side=[
    'belum terkonfirmasi'=>'unverified',
    'sudah terkonfirmasi'=>'verified'
],
STATS_ENCODE_side=[
    'unverified'=>'belum terkonfirmasi',
    'verified'=>'sudah terkonfirmasi'
];
class sidePengDana extends Model
{
    use response;

    protected $guarded = ['id','created_at','updated_at'];
    public $incrementing =false ;
    protected $appends=['key','pp','date_trans','img','source','category'];
    protected $hidden=['id','status','an','date','url','mst_id','mst_id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid ::generate(4);
        });
    }

    public static function getStatus()
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM side_peng_danas WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }
        return $values;
    }

    public function getObjN()
    {
        return $this->belongsTo(mstPengDana::class,'mst_id');
    }

    public static function checkStatus()
    {
        return STATS_DECODE_side;
    }
    public static function encodeStatus()
    {
        return STATS_ENCODE_side;
    }
    public function getCategoryAttribute()
    {
        return STATS_DECODE_side[$this->attributes['status']];
    }

    public function getKeyAttribute()
    {
        return $this->attributes['id'];
    }
    public function getPpAttribute()
    {
        return $this->attributes['an'];
    }
    public function getDateTransAttribute()
    {
        return $this->attributes['date'];
    }
    public function getImgAttribute()
    {
        return $this->checkImg($this->attributes['url']);
    }

    public function getSourceAttribute()
    {
        return mstPengDana::find($this->attributes['mst_id'])->name;
    }

}
