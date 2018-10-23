<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\orderClass;
use App\Http\Requests\indexOrder;
use App\Model\mstDisability;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\User;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\relation as Hub;

const types = ['name', 'sex', 'relligion', 'course', 'rs', 'needed', 'desc'];

class orderController extends Controller
{
    use orderClass;


    public function __construct()
    {
        $this->middleware('order');
    }

    public function order(Request $r)
    {
        $default = Selingan::index('Program');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $religion = User::getReligion();
        $rs = Hub::index();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $title = 'Pendaftaran Siswa Baru';
        $day = sideDaylist::all();
        $user_cookie=$r->data;

        return view('order', compact('default', 'gender', 'religion', 'rs', 'dis', 'title', 'day','user_cookie'));
    }

    /**set first impression for register new student
     * route
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function first(Request $r)
    {
        $this->validate($r, [
//            'name.*' => 'required',
            'sex.*' => 'required|exists:side_genders,id',
            'course.*' => 'required|exists:mst_classes,id',
            'relligion.*' => 'required|in:Islam,Non Muslim'
        ],[
            'required' => 'Harap isi kolom diatas',
            'exists' =>'harap tidak merubah data pada kolom atas',
            'in' =>'harap tidak merubah data pada kolom atas'
        ]);

//        $this->make_session($r);

        return redirect()->route('order');
    }


    /**
     * set request to array
     * @param $data
     * @return array
     */
    private function setSession($data)
    {
        $array = array();

        foreach (types as $i => $type) {
            if ($data->has($type)) {
                foreach ($data->only($type)[$type] as $z => $row) {
                    if (!array_key_exists($z, $array)) {
                        $array [$z] = array();
                    }
                    $array [$z] = array_replace($array [$z], [$type => $row]);
                }
            }
        }

        session()->put('order', $array);
    }

    public function overwrite(Request $r)
    {

    }


}
