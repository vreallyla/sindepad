<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\linkUserStudent;
use App\Model\mstClass;
use App\Model\mstDisability;
use App\Model\rsUserToStudent;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\relation as Hub;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

const types = ['name', 'gender', 'sex ', 'relligion ', 'course ', 'rs ', 'needed ', 'desc'];

class generalController extends Controller
{

    use extraClass;


    public function log(Request $r)
    {
//       $this->cookie_decode(['dasdasd'=>'dasdas'],10);

//        return auth()->user();
//return self::get_cookie_array();
//        $r->offsetUnset('token');
//        session()->put('regis_student',User::first());
//        return session()->get('regis_student')->id;
//        $a = 1;
//        for ($i = 0; $i < 12; $i++) {
//            $b[] = $a++;
//        }
//        return $b;



//        $users = DB::table('users')
//            ->whereMonth('created_at', $month++)
//            ->get();
//
//        if ($users){
//            income[$y]=keisi;
//        }
//        else{
//            income[$y]=0;
//        }
//        return User::where('name','dasd')->get();
//        $user=User::findOrFail('3e143e9c-8785-4306-83c6-c5a10b4b9487');
//
//        return substr($user->url,6);
//        $users = User::get();

// build your second collection with a subset of attributes. this new
// collection will be a collection of plain arrays, not Users models.
//        $subset = $users->map(function ($user) {
//            return collect($user->toArray())
//                ->only(['id', 'name', 'email'])
//                ->all();
//        });
//        return $subset[0]['id'];

//        foreach (rsUserToStudent::all() as $row){
//            $data[]= $row->getStudent->only('name');
//        }

    }

    public function log2()
    {
        self::remove_cookie(['dasdasd' => 'aaaa'], 10);
        return self::get_cookie_array();

    }

    public function index(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Beranda');
        $religion = User::getReligion();
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $title = 'Beranda';
        return view('index', compact('default', 'religion', 'gender', 'title', 'kodin', 'user_cookie'));
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
        $user_cookie = $r->data;;
        $default = Selingan::index('Kontak');
        $menu = 'Kontak';
        $title = 'Kontak Kami';
        return view('contact', compact('default', 'title', 'menu', 'user_cookie'));
    }

    public function courseOpsi(Request $r, $class)
    {
        $user_cookie = $r->data;;
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
