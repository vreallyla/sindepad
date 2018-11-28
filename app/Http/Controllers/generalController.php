<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\Model\mstClass;
use App\Model\mstDataPaket;
use App\Model\mstDisability;
use App\Model\mstTransactionList;
use App\Model\order\payingMethod;
use App\Model\Order\Setting\rulesTimeOption;
use App\Model\order\sideTypePrice;
use App\Model\Order\timeOption;
use App\Model\rsUserToStudent;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\relation as Hub;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;

const types = ['name', 'gender', 'sex ', 'relligion ', 'course ', 'rs ', 'needed ', 'desc'];

class generalController extends Controller
{

    use extraClass;
    public $anu = 1;

    public function log(Request $r)
    {
//        $client = new Client(['base_uri' => url('/')]);
//        $response = $client->get('api/a?_token='.csrf_token());

//        return json_decode($response->getBody(), true) ;
//        setlocale(LC_TIME, 'id');
//        foreach (range(1, 7) as $i) {
//            $id[] = \Carbon\Carbon::create(2018, 9, 8)->addDays($i)->formatLocalized('%A');
//        }
//        foreach (rulesTimeOption::first()->getTime()->orderBy('created_at','asc')->get() as $row){
//            $day[]=['day'=>$row->getTime,'time'=>$row->getDay];
//        }
//        session()->forget('order');
//
//        $day=sideDaylist::when(1==1,function ($query){
//           $query->orderBy('id','asc');
//        })->when(1==0,function ($query){
//            $query->orderBy('id','desc');
//        })->get();
//        $tahu=[1,2,3,4];
        $art=['sata','makan','sapi'];

        dd( array_search('S',$art));
    }

    public function log2()
    {

    }

    public function index(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Beranda');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $title = 'Beranda';
        $packet=/*$this->shortPacket()*/1;

        return view('index', compact('default', 'packet', 'gender', 'title', 'kodin', 'user_cookie'));
    }

    public function about(Request $r)
    {
        $user_cookie = $r->data;;
        $default = Selingan::index('Tentang Kami');
        $menu = 'Tentang Kami';
        $title = 'Tentang Sanggar ABK';
        return view('about', compact('default', 'title', 'menu', 'user_cookie'));
    }

    public function contact(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Kontak');
        $menu = 'Kontak';
        $title = 'Kontak Kami';
        return view('contact', compact('default', 'title', 'menu', 'user_cookie'));
    }

    public function courseOpsi(Request $r, $class)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $class = mstClass::findOrFail($class);
        $other = mstClass::where('name', '!=', $class->name)->orderBy('name', 'asc')->get();
        $title = 'Kelas ' . $class->name;
        $menu = 'Program';

        return view('class.index', compact('default', 'class', 'other', 'title', 'menu', 'user_cookie'));
    }

    public function course(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';

        return view('class.all', compact('default', 'title', 'menu', 'user_cookie'));
    }

    public function order(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $religion = User::getReligion();
        $rs = Hub::index();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $title = 'Pendaftaran Siswa Baru';
        $day = sideDaylist::all();

        return view('order', compact('default', 'gender', 'religion', 'rs', 'dis', 'title', 'day', 'user_cookie'));
    }

    public function logout(Request $r)
    {
//        $check = self::checkCookie() ? $r->request->add(['token' => self::get_cookie()->token]) : true;
//        $msg='gagal keluar...';
//
//        if (!$check){
//            $msg=$this->logout_now();
//        }
//
//        return redirect()->back()->with('msg',$msg);
    }
}
