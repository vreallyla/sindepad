<?php

namespace App\Http\Controllers;

use App\contact;
use App\Model\mstClass;
use App\Model\sideGender;
use App\sideCity;
use App\sideProvince;
use App\User;
use App\verifyUser;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;

class generalController extends Controller
{
    public function log()
    {

        return User::has('verification')->get();
    }

    public function index()
    {
        $default=Selingan::index('Beranda');
        $religion=User::getReligion();
        return view('index',compact('default','religion'));
    }

    public function about()
    {
        $default=Selingan::index('Tentang Kami');
        $menu='Tentang Kami';

        return view('about',compact('default'));
    }
    public function contact()
    {
        $default=Selingan::index('Kontak');
        $menu='Kontak';

        return view('contact',compact('default'));
    }

    public function courseOpsi($class)
    {
        $default=Selingan::index('Program');

        $class=mstClass::findOrFail($class);

        return view('class.index',compact('default','class'));
    }

    public function course()
    {
        $default=Selingan::index('Program');
        return view('class.all',compact('default'));
    }
}
