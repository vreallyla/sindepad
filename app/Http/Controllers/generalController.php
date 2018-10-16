<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\extraClass;
use App\Model\mstClass;
use App\Model\mstDisability;
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
//        try {
//            // my data storage location is project_root/storage/app/data.json file.
//            $contactInfo = Storage::disk('local')->exists('rhs/data.json') ? json_decode(Storage::disk('local')->get('rhs/data.json')) : [];
//
//            $inputData =['sandi'=>'323','anu'=>'ex2dddeea23'];

//            $inputData['datetime_submitted'] = date('Y-m-d H:i:s');

//            array_push($contactInfo['name'],$inputData);
//            $contactInfo[]=$inputData;

//            Storage::disk('local')->put('rhs/data.json', json_encode($contactInfo));

//            foreach ($contactInfo as $as){
//                return $as->sandi;
//            }
//            return array_column($contactInfo,'sandi')[0];
//
//        } catch(\Exception $e) {
//
//            return ['error' => true, 'message' => $e->getMessage()];
//
//        }
//        $check = $this->checkCookie() ? $r->request->add(['token' => self::get_cookie()->token]) : true;
//        return !$check ? $this->refreshWithCookie() : false;
//        $r->offsetUnset('token');

//        return $check;
self::remove_cookie(['dajhsd'=>123123],12);
//        return self::get_cookie()->token;


    }

    public function index(Request $r)
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Beranda');
        $religion = User::getReligion();
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $title = 'Beranda';
        return view('index', compact('default', 'religion', 'gender', 'title', 'kodin', 'user_cookie'));
    }

    public function about()
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Tentang Kami');
        $menu = 'Tentang Kami';
        $title = 'Tentang Sanggar ABK';
        return view('about', compact('default', 'title', 'menu', 'user_cookie'));
    }

    public function contact()
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Kontak');
        $menu = 'Kontak';
        $title = 'Kontak Kami';
        return view('contact', compact('default', 'title', 'menu','user_cookie'));
    }

    public function courseOpsi($class)
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Program');
        $class = mstClass::findOrFail($class);
        $other = mstClass::where('name', '!=', $class->name)->orderBy('name', 'asc')->get();
        $title = 'Kelas ' . $class->name;
        $menu = 'Program';

        return view('class.index', compact('default', 'class', 'other', 'title', 'menu','user_cookie'));
    }

    public function course()
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';

        return view('class.all', compact('default', 'title', 'menu','user_cookie'));
    }

    public function order()
    {
        $user_cookie = self::check_user();
        $default = Selingan::index('Program');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $religion = User::getReligion();
        $rs = Hub::index();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $title = 'Pendaftaran Siswa Baru';
        $day = sideDaylist::all();

        return view('order', compact('default', 'gender', 'religion', 'rs', 'dis', 'title', 'day','user_cookie'));
    }
}
