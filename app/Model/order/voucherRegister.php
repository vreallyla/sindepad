<?php

namespace App\Model\order;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

const REBATE = [
    'Diskon' => 'percent',
    'Potong Harga' => 'cash'
];

class voucherRegister extends Model
{
    protected $dates = ['created_at', 'updated_at', 'expired'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['code', 'id', 'type', 'deleted_at', 'updated_at'];
    protected $columns = array('code', 'type'); // add all columns from you table
    public $incrementing = false;

    public $appends = [
        'tag',
        'status',
        'remaining',
        'voucher',
        'key'
    ];

    public function scopeExclude($query, $value = array())
    {
        return $query->select(array_diff($this->columns, (array)$value));
    }

    /**
     * hide column query
     */

    public function getTagAttribute()
    {
        return REBATE[$this->attributes['type']];
    }

    public function getVoucherAttribute()
    {
        return $this->attributes['code'];
    }

    public function getKeyAttribute()
    {
        return $this->attributes['id'];
    }



    /**
     * show status voucher
     */

    public function getStatusAttribute()
    {
        return Carbon::parse($this->attributes['expired'])->gte(now()) ? 'Aktif' : 'Kadaluarsa';
    }

    public function getRemainingAttribute()
    {
        setlocale(LC_TIME, 'id');

        return (now()->gt($this->attributes['expired']) ? 'Waktu terlewat ' : 'sisa waktu ') . now()->diffInDays($this->attributes['expired']) . ' hari';
    }


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
}
