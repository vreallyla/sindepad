<?php

namespace App\Http\Controllers\Simdepad;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\sideGender;
use App\Model\sideLastEducation;
use App\Model\sideProfessionList;
use App\rsStudentFamily;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class userInController extends Controller
{

    use extraClass;

    public function __construct()
    {
        $this->middleware('order');
//        $this->middleware('shadowRole');

    }

    /**
     * @return array
     * get kid if actice
     */
    private function getChild()
    {
        $own = $this->getId()->getRsStudent()->orderBy('created_at', 'desc')->get();
        $child = [];
        $date = now()->subMonths(1);
        foreach ($own as $row) {
            if ($student = $row->getStudent()->where('status', 'Active')->whereDate('register', '>=', $date->toDateString())->first()) {
                $child[] = self::convertToObject(array_merge($student->only('name', 'ni'), [
                    'key' => $student->id
                    , 'img' => $this->checkImg($student->url)
                ]));
            }
        }

        return $child;
    }


    public function getEvaluations(Request $r)
    {
        $title = 'Beranda';
        $sub = 'Pengguna';
        $token = $r->token;
        $data = $r->data;
        $child = $this->getChild();


        return view('user.in.evaluations.index_evaluations', compact('title', 'sub', 'token', 'data', 'child'));
    }


    public function index(Request $r)
    {
        $title = 'Beranda';
        $sub = 'Pengguna';
        $token = $r->token;
        $data = $r->data;

        $child = $this->getChild();


        return view('user.in.home.user_home', compact('title', 'sub', 'token', 'data', 'child'));
    }

    public function scheList(Request $r)
    {
        $title = 'Jadwal';
        $sub = 'Daftar';
        $token = $r->token;
        $data = $r->data;
        $child = $this->getChild();


        return view('user.in.sche.user_sche', compact('title', 'sub', 'token', 'data', 'child'));
    }

    public function scheAct(Request $r)
    {
        $title = 'Jadwal';
        $sub = 'Aktifitas';
        $token = $r->token;
        $data = $r->data;


        return view('user.in.sche.user_act', compact('title', 'sub', 'token', 'data'));
    }

    public function tracking(Request $r)
    {
        $title = 'Monitoring';
        $sub = 'Pendamping';
        $token = $r->token;
        $data = $r->data;
        $student = $this->getId();

        $child = $this->getChild();

        return view('user.in.monitoring.tracking_user', compact('title', 'sub', 'token', 'data', 'child'));
    }

    public function profile(Request $r)
    {
        $title = '';
        $sub = '';
        $token = $r->token;
        $data = $r->data;
        $user = $this->getId();
        $dataFams = rsStudentFamily::where('user_id', $user->id)->first();

        $other = self::convertToObject(['sex' => sideGender::orderBy('created_at', 'asc')->get(),
            'edu' => sideLastEducation::orderBy('created_at', 'asc')->get(),
            'profesion' => sideProfessionList::orderBy('created_at', 'asc')->get(),
            'personal' => self::convertToObject(
                array_merge($user->only('email', 'ni', 'name', 'born_place', 'dob', 'phone', 'address'), [
                    'gender_key' => $user->gender_id,
                    'status' => $user->getStatus->ind,
                    'edu' => $dataFams ? $dataFams->education_id : '',
                    'profession' => $dataFams ? $dataFams->profession_id : ''
                ]))]);

        $child = $this->getChild();

        return view('user.in.profile.user_profile', compact('title', 'sub', 'token', 'data', 'other', 'child'));
    }
}
