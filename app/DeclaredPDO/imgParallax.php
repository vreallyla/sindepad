<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 17/12/2018
 * Time: 16:34
 */

namespace App\DeclaredPDO;


use Illuminate\Support\Facades\File;

class imgParallax
{
    public static function getImgN()
    {
        $img=[
          '1.jpg',
          '2.jpg',
          '3.jpg',
          '4.jpg',
          '5.jpg',
          '6.jpg',
          '7.jpg',
          '8.jpg',
        ];
        $choose='images/parallax/'.$img[rand(0,7)];
        return File::exists($choose)?asset($choose):asset('images/img_unvailable.png');
}
}