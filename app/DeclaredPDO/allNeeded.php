<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 31/08/2018
 * Time: 22:28
 */

namespace App\DeclaredPDO;


use App\contact;
use App\Model\mstClass;

class allNeeded
{
    public static function index($menu)
    {
        try{
            $r[]=contact::all()->first();
            $r[]=mstClass::orderBy('name','asc')->get();
            $r[]=$menu;
        }catch (\Exception $e){
            return abort(503);
        }

        return $r;
    }
}