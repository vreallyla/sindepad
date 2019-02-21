<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class rsEvaluation extends Model
{
    protected $guarded = [ 'created_at', 'updated_at'];
    public $incrementing = false;

}
