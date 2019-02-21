<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\imgParallax;
use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_activities\mstActivity;
use App\Model\Admin\news\MstNewsList;
use App\Model\Admin\settings\DataSlide;
use App\Model\linkUserStudent;
use App\Model\mstDisability;
use App\Model\order\voucherRegister;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\mstHub;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\relation as Hub;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


const types = ['name', 'gender', 'sex ', 'relligion ', 'course ', 'rs ', 'needed ', 'desc'];

class generalController extends Controller
{

    use extraClass;
    public $anu = 1;

    public function log(Request $r)
    {

       return Carbon::parse('2018-12-09')->diffInMonths(now()->toDateString()); // 1

//        return Carbon::createFromFormat('');
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
        $ar = ['a' => 'd', 'sde' => 'tr', 'dasd' => 'f'];

//        reset($ar);
        $first_key = key($ar);
        return $first_key;

        return User::find('82580ef0-28af-4897-8a8c-6de2b39a48e0');
    }

    public function log2($model)
    {
        $i = 0;
        do {
            echo $i;
        } while ($i > 0);

    }

    public function signout(Request $r)
    {
        Auth::guard('api')->logout();
        Session::forget('uzanto');

        return redirect()->route('welcome');

    }

    public function index(Request $r)
    {

        $user_cookie = $r->data;
        $default = Selingan::index('Beranda');

        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $title = 'Beranda';
//        $packet=/*$this->shortPacket()*/1;
        $slide = DataSlide::all();
        $hub = mstHub::orderBy('created_at', 'asc')->get();
        $needed = mstDisability::orderBy('name', 'asc')->get();
        $parralax=imgParallax::getImgN();
        $news=MstNewsList::orderBy('created_at','desc')->paginate(9);

        return view('index', compact('default'/*, 'packet'*/, 'gender', 'title', 'kodin', 'user_cookie', 'slide', 'hub', 'needed','parralax','news'));
    }

    public function about(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Tentang Kami');
        $menu = 'Tentang Kami';
        $title = 'Tentang '.env('APP_NAME');
        $parralax=imgParallax::getImgN();

        return view('about', compact('default', 'title', 'menu', 'user_cookie','parralax'));
    }

    public function privacy(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Tentang Kami');
        $menu = 'Privacy Policy';
        $title = 'privacy policy '.env('APP_NAME');
        $parralax=imgParallax::getImgN();

        return view('privacy_policy', compact('default', 'title', 'menu', 'user_cookie','parralax'));
    }

    public function contact(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Kontak');
        $menu = 'Kontak';
        $title = 'Kontak Kami';
        $parralax=imgParallax::getImgN();

        return view('contact', compact('default', 'title', 'menu', 'user_cookie','parralax'));
    }

    public function courseOpsi(Request $r, $class)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $class = mstActivity::findOrFail($class);
        $other = mstActivity::where('name', '!=', $class->name)->orderBy('name', 'asc')->get();
        $title = 'Kegiatan ' . $class->name;
        $menu = 'Program';
        $parralax=imgParallax::getImgN();


        return view('class.index', compact('default', 'class', 'other', 'title', 'menu', 'user_cookie','parralax'));
    }

    public function course(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';
        $parralax=imgParallax::getImgN();
        $dataN=mstActivity::orderBy('created_at','desc')->paginate(9);

        return view('class.all', compact('default', 'title', 'menu', 'user_cookie','parralax','dataN'));
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
        $parralax=imgParallax::getImgN();

//        return $parralax;


        return view('order', compact('default', 'gender', 'religion', 'rs', 'dis', 'title', 'day', 'user_cookie','parralax'));
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
