<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 31/08/2018
 * Time: 22:28
 */

namespace App\DeclaredPDO;


use App\contact;
use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_activities\mstActivity;
use App\Model\Admin\news\sideNewsCategory;
use App\Model\mstClass;
use App\Model\mstTransactionList;
use App\Model\sideGender;
use Illuminate\Support\Facades\Auth;

class allNeeded
{
    use extraClass;

    public static function index($menu)
    {

        try{
            $r[]=contact::all()->first();
            $r[]=mstActivity::orderBy('name','asc')->get();
            $r[]=$menu;
            $r[]=sideNewsCategory::orderBy('name','asc')->get();
            $r[]=sideGender::orderBy('created_at','asc')->get();
        }catch (\Exception $e){
            return abort(503);
        }

        return $r;
    }
}