<?php

namespace App\Http\Controllers\Admin;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_activities\mstActivity;
use App\Model\_sche\mstSchecule;
use App\Model\Admin\news\sideNewsCategory;
use App\Model\general\dataBank;
use App\Model\linkUserStudent;
use App\Model\mstDisability;
use App\Model\order\payingMethod;
use App\Model\sideGender;
use App\Model\sideLastEducation;
use App\Model\sideMaritalStatus;
use App\Model\sideStatusUser;
use App\mstHub;
use App\sideNote;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    use extraClass;

    public function __construct()
    {
        $this->middleware('order');
//        $this->middleware('adminRole');

    }

    public function index(Request $r)
    {
        $title = 'Beranda';
        $sub = 'Admin';
        $token = $r->token;
        $data = $r->data;

        $entity = self::convertToObject([
            'user' => count(sideStatusUser::where('ind', 'User')->first()->getUser()->get()),
            'pengajar' => count(sideStatusUser::where('ind', 'Pengajar')->first()->getUser()->get()),
            'student' => count(linkUserStudent::all())
        ]);

        $a = now();
        $now = $a->copy()->toDateString();
        $dateNow = $a->copy()->subMonths(1)->toDateString();



        $graph = [];
        $graph['user'] = [];
        $graph['shadow'] = [];
        $graph['student'] = [];
        foreach (CarbonPeriod::create($dateNow, $now)->toArray() as $i => $row) {
            if (!sideStatusUser::where('ind', 'User')->first()->getUser()->whereDate('created_at', $row->toDateString())->get()->isEmpty()) {

                $graph['user'][] = self::convertToObject(['date' => $row->toDateString(), 'entity' => count(sideStatusUser::where('ind', 'User')->first()->getUser()->whereDate('created_at', $row->toDateString())->get())]);
            }

            if (!sideStatusUser::where('ind', 'Pengajar')->first()->getUser()->whereDate('created_at', $row->toDateString())->get()->isEmpty()) {

                $graph['shadow'][] = self::convertToObject(['date' => $row->toDateString(), 'entity' => count(sideStatusUser::where('ind', 'Pengajar')->first()->getUser()->whereDate('created_at', $row->toDateString())->get())]);
            }

            if (!linkUserStudent::whereDate('created_at', $row->toDateString())->get()->isEmpty()) {

                $graph['student'][] = self::convertToObject(['date' => $row->toDateString(), 'entity' => count(linkUserStudent::whereDate('created_at', $row->toDateString())->get())]);
            }


        }


        return view('admin.index', compact('title', 'sub', 'token', 'data', 'entity', 'graph'));


    }

    public function discon(Request $r)
    {

        $title = 'Transaksi';
        $sub = 'Daftar Diskon';
        $token = $r->token;
        $data = $r->data;
        return view('admin.trans.discon.adm_disc_set', compact('title', 'sub', 'data', 'token'));
    }

    public function loadBank(Request $r){
        $title = 'Pengatutan';
        $sub = 'Metode Pembayaran';
        $token = $r->token;
        $data = $r->data;
        $bank=dataBank::orderBy('created_at','asc')->get();
        return view('admin.settings.bank_set.adm_bank_set', compact('title', 'sub', 'data', 'token','bank'));
    }
    public function newsCategory(Request $r)
    {
        $title = 'Informasi';
        $sub = 'Kategori';
        $token = $r->token;
        $data = $r->data;
        return view('admin.news.category.adm_news_categories', compact('title', 'sub', 'data', 'token'));
    }

    public function newsList(Request $r)
    {
        $title = 'Informasi';
        $sub = 'Daftar';
        $token = $r->token;
        $data = $r->data;

        $category = sideNewsCategory::orderBy('name', 'asc')->get();
        return view('admin.news.list.adm_news_list', compact('title', 'sub', 'data', 'token', 'category'));
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

    public function slide(Request $r)
    {
        $title = 'Pengaturan';
        $sub = 'Slide Beranda';
        $token = $r->token;
        $data = $r->data;

        return view('admin.settings.slides.slide', compact('title', 'sub', 'token', 'data'));
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
        $sche = mstActivity::orderBy('name', 'asc')->get();

        return view('admin.studentConfig.schedule.schedule', compact('title', 'sub', 'token', 'data', 'sche'));
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

    public function sideProfile(Request $r)
    {
        $title = '';
        $sub = '';
        $token = $r->token;
        $data = $r->data;
        $user = $this->getId();

        $other = self::convertToObject(['sex' => sideGender::orderBy('created_at', 'asc')->get(),
            'edu' => sideLastEducation::orderBy('created_at', 'asc')->get(),
            'rel' => sideMaritalStatus::orderBy('created_at', 'asc')->get(),
            'personal' => self::convertToObject(
                array_merge($user->only('email', 'ni', 'name', 'born_place', 'dob', 'phone', 'address'), [
                    'gender_key' => $user->gender_id,
                    'status' => $user->getStatus->ind,
                    'edu'=>$user->getTeacher?$user->getTeacher->education_id:'',
                    'rel'=>$user->getTeacher?$user->getTeacher->marital_id:''
                ]))]);


        return view('admin.adm_profile', compact('title', 'sub', 'token', 'data', 'other'));
    }

}
