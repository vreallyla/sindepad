<?php

namespace App\Http\Controllers\Admin;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\mstDisability;
use App\Model\sideGender;
use App\Model\sideStatusUser;
use App\mstHub;
use App\sideNote;
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
        $sub = 'Admin';
        $token = $r->token;
        $data = $r->data;

        return view('admin.index', compact('title', 'sub', 'token', 'data'));
    }

    public function register(Request $r)
    {
        $title = 'Transaksi';
        $sub = 'Daftar Pendaftaran';
        $token = $r->token;
        $data = $r->data;
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $rs = mstHub::orderBy('created_at', 'asc')->get();

        return view('admin.registerList.adm_register', compact('title', 'sub', 'token', 'gender', 'dis', 'rs', 'data'));
    }

    public function aggre(Request $r)
    {

        $title = 'Pengaturan';
        $sub = 'Persetujuan';
        $token = $r->token;
        $data = $r->data;
        $aggrement = sideNote::where('status', 'active')->first();
        return view('admin.settings.aggrement.aggrement', compact('title', 'sub', 'token', 'aggrement', 'data'));

    }

    public function price(Request $r)
    {
        $title = 'Pengaturan';
        $sub = 'Harga';
        $token = $r->token;
        $data = $r->data;
        return view('admin.settings.price.price', compact('title', 'sub', 'token', 'data'));
    }

    public function tuition(Request $r)
    {
        $title = 'Transaksi';
        $sub = 'SPP';
        $token = $r->token;
        $data = $r->data;
        return view('admin.trans.tuition.tuition', compact('title', 'sub', 'token', 'data', 'data'));
    }

    public function activity(Request $r)
    {
        $title = 'Peserta Didik';
        $sub = 'Pengaturan Kegiatan';
        $token = $r->token;
        $data = $r->data;

        return view('admin.studentConfig.activity.activity', compact('title', 'sub', 'token', 'data'));
    }

    public function schedule(Request $r)
    {
        $title = 'Peserta Didik';
        $sub = 'Pengaturan Jadwal';
        $token = $r->token;
        $data = $r->data;

        return view('admin.studentConfig.schedule.schedule', compact('title', 'sub', 'token', 'data'));
    }

    public function users(Request $r)
    {
        $title = 'Data Master';
        $sub = 'Pengguna';
        $token = $r->token;
        $data = $r->data;
        $roleUser = sideStatusUser::pluck('ind');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        return view('admin.master.user.users', compact('title', 'sub', 'token', 'roleUser', 'gender', 'data'));
    }

    public function shadow(Request $r)
    {
        $title = 'Pengaturan';
        $sub = 'Pendamping';
        $token = $r->token;
        $data = $r->data;
        $user = sideStatusUser::where('ind', 'Pengajar')->first();
        $teacher = $user->getUser()->orderBy('name', 'asc')->get();
        return view('admin.settings.shadow.adm_shadow', compact('title', 'sub', 'token', 'data', 'teacher'));
    }
}
