<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class verifyUser extends Model
{
    public $incrementing =false ;
    protected $fillable=['user_id','token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
