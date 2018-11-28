<?php

namespace App\Http\Controllers\Admin;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\mstTransactionList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    use extraClass;

    public function __construct()
    {
        $this->middleware('order');
        $this->middleware('adminRole');

    }

    public function index(Request $r)
    {
        $title = 'Beranda';
        $sub='Admin';
        $token=$r->token;

        return view('admin.index', compact('title','sub','token'));
    }

    public function register(Request $r)
    {
        $title = 'Transaksi';
        $sub='Daftar Pendaftaran';
        $token=$r->token;

        return view('admin.registerList.adm_register', compact('title','sub','token'));
    }

    public function rpp(Request $r)
    {
        $title= 'Pengaturan';
        $sub='Rencana Pelaksanaan Pembelajaran';
        $token=$r->token;

        return view('admin.settings.rpp.rpp',compact('title','sub','token'));
    }


}
