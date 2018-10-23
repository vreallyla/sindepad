<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 16/10/2018
 * Time: 14:20
 */

namespace App\DeclaredPDO;


trait orderClass
{
    private function make_session($res)
    {
        session()->put('regis_student',json_encode($res));
    }
}