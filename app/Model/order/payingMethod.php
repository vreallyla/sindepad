<?php

namespace App\Model\order;

use App\Model\general\dataBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class payingMethod extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
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

    public static function getMethod(){
        $type = DB::select(DB::raw('SHOW COLUMNS FROM paying_methods WHERE Field = "method"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }

    public function get_bank()
    {
        return $this->belongsTo(dataBank::class,'bank_id');
    }
}
