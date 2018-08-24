<?php

namespace App\Http\Controllers;

use App\Model\sideGender;
use App\sideCity;
use App\sideProvince;
use Illuminate\Http\Request;

class generalController extends Controller
{
    public function log()
    {
        return sideGender::where('en','Male')->first()->id;
    }
}
