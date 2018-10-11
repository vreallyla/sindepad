<?php

namespace App\Http\Controllers;

use App\Model\mstClass;
use App\Model\mstDisability;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\relation as Hub;
use Illuminate\Support\Facades\Storage;

const types = ['name', 'gender', 'sex ', 'relligion ', 'course ', 'rs ', 'needed ', 'desc'];

class generalController extends Controller
{
    public function log(Request $request)
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

    }


    function convertToObject($array)
    {
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }


    public function index()
    {
        $default = Selingan::index('Beranda');
        $religion = User::getReligion();
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $title = 'Beranda';
        return view('index', compact('default', 'religion', 'gender', 'title'));
    }

    public function about()
    {
        $default = Selingan::index('Tentang Kami');
        $menu = 'Tentang Kami';
        $title = 'Tentang Sanggar ABK';
        return view('about', compact('default', 'title', 'menu'));
    }

    public function contact()
    {
        $default = Selingan::index('Kontak');
        $menu = 'Kontak';
        $title = 'Kontak Kami';
        return view('contact', compact('default', 'title', 'menu'));
    }

    public function courseOpsi($class)
    {
        $default = Selingan::index('Program');
        $class = mstClass::findOrFail($class);
        $other = mstClass::where('name', '!=', $class->name)->orderBy('name', 'asc')->get();
        $title = 'Kelas ' . $class->name;
        $menu = 'Program';

        return view('class.index', compact('default', 'class', 'other', 'title', 'menu'));
    }

    public function course()
    {
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';

        return view('class.all', compact('default', 'title', 'menu'));
    }

    public function order()
    {
        $default = Selingan::index('Program');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $religion = User::getReligion();
        $rs = Hub::index();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $title = 'Pendaftaran Siswa Baru';
        $day = sideDaylist::all();

        return view('order', compact('default', 'gender', 'religion', 'rs', 'dis', 'title', 'day'));
    }
}
