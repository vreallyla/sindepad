<?php

namespace App\Model\Peng;

use App\DeclaredPDO\response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

const STATS_DECODE = [
    'Proses' => 'proccess',
    'Sukses' => 'closed'
],
STATS_ENCODE = [
    'proccess' => 'Proses',
    'closed' => 'Sukses'
];

class mstPengDana extends Model
{
    use response;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['id', 'kode', 'desc', 'status', 'url'];
    public $incrementing = false;
    protected $appends = [
        'key', 'code', 'detail', 'collected', 'category', 'img'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }

    public function getContributor()
    {
        return $this->hasMany(sidePengDana::class, 'mst_id');
    }

    public static function getStatus()
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM mst_peng_danas WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }
        return $values;
    }

    public static function checkStatus()
    {
        return STATS_DECODE;
    }

    public static function encodeStatus()
    {
        return STATS_ENCODE;
    }

    public static function codeFund()
    {
        do {
            $kode = now()->format('ym') . sprintf("%06d", rand(000001, 999999));
        } while (!mstPengDana::where('kode', $kode)->get()->isEmpty());

        return $kode;
    }

    public function getKeyAttribute()
    {
        return $this->attributes['id'];
    }

    public function getCodeAttribute()
    {
        return $this->attributes['kode'];
    }

    public function getDetailAttribute()
    {
        return $this->attributes['desc'];
    }

    public function getCategoryAttribute()
    {
        return STATS_DECODE[$this->attributes['status']];
    }

    public function getCollectedAttribute()
    {
        $data = sidePengDana::where('mst_id', $this->attributes['id'])
            ->where('status', 'sudah terkonfirmasi')->pluck('nominal');

        return $data->isEmpty() ? 0 : array_sum($data->toArray());
    }

    public function getImgAttribute()
    {
        return $this->checkImg($this->attributes['url']);
    }

}
