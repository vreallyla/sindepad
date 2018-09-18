<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 10/09/2018
 * Time: 23:03
 */

namespace App\DeclaredPDO;


class relation
{

    public static function index()
    {
        return array(
            'en' => array('Parent', 'Kerabat', 'Custodian', 'Other'),
            'id' => array('Orang Tua', 'Kerabat', 'Wali', 'Lainnya'),
        );
    }
}