<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 16/10/2018
 * Time: 14:20
 */

namespace App\DeclaredPDO;


class orderClass
{
    protected $data=null;
    protected $qty=0;
    protected $total=0;

    public function __construct($data)
    {
        $this->data=$data;
    }

    public function detacth_session($res)
    {
        session()->put('order',$res);
    }
}