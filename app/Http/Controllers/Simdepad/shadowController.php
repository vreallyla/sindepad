<?php

namespace App\Http\Controllers\Simdepad;

use App\DeclaredPDO\Jwt\extraClass;
use App\Model\_sche\mstSchecule;
use App\Model\sideGender;
use App\Model\sideLastEducation;
use App\Model\sideMaritalStatus;
use App\Model\sideStatusUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class shadowController extends Controller
{

    use extraClass;

    public function __construct()
    {
        $this->middleware('order');
//        $this->middleware('shadowRole');

    }

    private function getDataStudent($user)
    {
        $student = [];

        foreach ($user->getRsHomerooms as $row) {
            $student[] = self::convertToObject(array_merge($row->getStud->only('name', 'ni','id'), ['img'=>$this->checkImg($row->getStud->url)]));
        }

        return $student;
    }

    public function index(Request $r)
    {
        $title = 'Beranda';
        $sub = 'Pendamping';
        $token = $r->token;
        $data = $r->data;

        $student = $this->getDataStudent($this->getId());


        return view('shadow.home.index_shadow', compact('title', 'sub', 'token', 'data','student'));
    }

    public function scheList(Request $r)
    {
        $title = 'Jadwal';
        $sub = 'Daftar';
        $token = $r->token;
        $data = $r->data;

        return view('shadow.sche.list.shadow_sche', compact('title', 'sub', 'token', 'data'));
    }

    public function evaluation(Request $r)
    {
        $title = 'Evaluasi';
        $sub = 'Daftar';
        $token = $r->token;
        $data = $r->data;
        $student = $this->getDataStudent($this->getId());

        return view('shadow.evaluations.index_evaluations', compact('title', 'sub', 'token', 'data','student'));
    }

    public function scheAct(Request $r)
    {
        $title = 'Jadwal';
        $sub = 'Aktifitas';
        $token = $r->token;
        $data = $r->data;

        return view('shadow.sche.act.shadow_act', compact('title', 'sub', 'token', 'data'));
    }

    public function scheStudent(Request $r)
    {
        $title = 'Jadwal';
        $sub = 'Peserta Didik';
        $token = $r->token;
        $data = $r->data;
        $sche = mstSchecule::orderBy('name', 'asc')->get();

        return view('shadow.sche.student.shadow_sche_student', compact('title', 'sub', 'token', 'data', 'sche'));
    }

    public function users(Request $r)
    {
        $title = 'Pengguna';
        $sub = '';
        $token = $r->token;
        $data = $r->data;
        $roleUser = sideStatusUser::pluck('ind');

        return view('shadow.users.shadow_users', compact('title', 'sub', 'token', 'data', 'roleUser'));
    }

    public function tracking(Request $r)
    {
        $title = 'Monitoring';
        $sub = 'Pendamping';
        $token = $r->token;
        $data = $r->data;
        $student = $this->getId();
        $homerooms = [];

        foreach ($student->getRsHomerooms as $row) {
            $stund = $row->getStud;
            if ($stund->status === 'Active' && Carbon::parse($stund->register)->addMonths(1)->gt(now()))
                $homerooms[] = self::convertToObject($row->getStud->only('name', 'id'));
        }

        return view('shadow.tracking.shadow_tracking', compact('title', 'sub', 'token', 'data', 'homerooms'));
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
                    'edu' => $user->getTeacher ? $user->getTeacher->education_id : '',
                    'rel' => $user->getTeacher ? $user->getTeacher->marital_id : ''
                ]))]);


        return view('shadow.side.shadow_profile', compact('title', 'sub', 'token', 'data', 'other'));
    }
}
