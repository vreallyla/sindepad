<?php

namespace App\Http\Controllers\User;

use App\DeclaredPDO\imgParallax;
use App\Model\sideGender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DeclaredPDO\allNeeded as Selingan;


class ProfileController extends Controller
{
    public function index(Request $r)
    {
        $user_cookie=$r->data;
        $default = Selingan::index('Tentang Kami');
        $menu = 'Tentang Kami';
        $title = 'Tentang Sanggar ABK';
        $more=$r->more;
        $token=$r->token;
        $jk=sideGender::orderBy('ind','desc')->get();
        $kids=$r->kids;
        $parralax=imgParallax::getImgN();


        return view('user.profile.index',compact('default','menu','title','user_cookie','more','token','jk','kids','parralax'));
    }
}
