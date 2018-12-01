<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 29/11/2018
 * Time: 0:46
 */

namespace App\DeclaredPDO\Admin\Master;

const TYPE_USER = ['Admin', 'Pengajar', 'User', 'Peserta Didik', 'Hub'];
const STATUS_USER = ['Non Aktif', 'Aktif', 'Kadaluwarsa'];
const STATUS_STUDENT = [
    'Non Active' => STATUS_USER[0], 'Active' => STATUS_USER[1]
];

use App\DeclaredPDO\response;
use App\linkStudentFamily;
use App\Model\linkUserStudent;
use App\Model\sideStatusUser;
use App\rsStudentFamily;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class users
{
    use response;
    protected $re;

    public function __construct($eloq)
    {
        $this->re = $eloq;
    }

    public static function searchSome($arr, $q)
    {
        $new = [];
        foreach ($arr as $tow) {
            if (strpos(strtolower($tow['name']), strtolower($q)) !== false) {
                $new[] = $tow;
                break;
            }

        }
        return $new;
    }

    private function getIDStatus()
    {
        return sideStatusUser::where('ind', $this->re->cat)->first();
    }

    public function getUsers()
    {
        return $this->getIDStatus() ? $this->conUser($this->getIDStatus()->getUser()->withTrashed()->orderBy('updated_at', 'desc')->get()) : $this->notFound();
    }

    private function conUser($set)
    {
        $arr = [];
        foreach ($set as $i => $row) {
            $arr[] = $row->only('name', 'id');
            $arr[$i]['img'] = $this->checkImg($row->url);
        }
        return $arr;
    }

    public function getStudents()
    {
        return $this->conUser($this->listUser());
    }

    private function listUser()
    {
        return linkUserStudent::where('status', 'Active')->orderBy('updated_at', 'desc')->get();
    }

    private function getOneUser()
    {
        $user = User::withTrashed()->find($this->re->key);
        return $user && ($user ? $user->getStatus->ind === $this->re->cat : false) ? $user : false;
    }

    private function getOneStudent()
    {
        return linkUserStudent::find($this->re->key);
    }

    private function getOneHub()
    {
        return rsStudentFamily::find($this->re->key);
    }

    public function getspes()
    {
        $cat = $this->re->cat;
        $model = $cat === TYPE_USER[3] ? $this->getOneStudent() :
            ($cat === TYPE_USER[4] ? $this->getOneHub()->getFami : $this->getOneUser());

        return $model ? $this->setArray($model, $cat) : $this->notFound();
    }

    private function setArray($model, $cat)
    {
        setlocale(LC_TIME, 'id');
//        \Illuminate\Support\Facades\App::setlocale('id');
        $ar = $model->only('name', 'id', 'phone', 'address');
        $ar['numb_regist'] = $model->ni ? $model->ni : 'belum terdatar';
        $ar['dob'] = $model->born_place && $model->dob ? $model->born_place . ', ' . Carbon::createFromFormat('Y-m-d', $model->dob)->formatLocalized('%d %b %Y') :
            null;
        $ar['status'] = $cat === TYPE_USER[3] ? $this->checkStatusStudent($model) : ($cat === TYPE_USER[4] ?
            $this->checkStatusHub($model) : $this->checkStatusUser($model));
        $ar['img'] = $this->checkImg($cat === TYPE_USER[4] ? ($this->getOneHub()->user_id ? $this->getOneHub()->getUser->url : null) : $model->url);
        $ar['gender'] = $model->getSex->ind;
        $ar['cat'] = $cat;
        $ar = array_merge($ar, ($cat === TYPE_USER[3] ? $this->additionalStudent($model) : ($cat === TYPE_USER[4] ?
            [/*TO DO*/] : $this->addiEmail($model))));

        if ($this->re->cat === TYPE_USER[1]) {
            $ar = array_merge($ar, $this->addiPengajar($model->getRsHomerooms));

        } elseif ($this->re->cat === TYPE_USER[2]) {
            $ar = array_merge($ar, $this->addiUser($model));
        }
        return $ar;
    }

    private function addiPengajar($model)
    {
        $arr = [];
        foreach ($model as $row) {
            $student = $row->getStud;
            $arr['rel'][] = [
                'name' => $student->name,
                'notice' => 'Sebagai ' . TYPE_USER[1],
                'key' => $student->id,
                'status' => TYPE_USER[3]
            ];
        }
        return $arr;
    }

    private function addiUser($model)
    {
        $ar = [];

        foreach ($model->getRsStudent as $row) {
            $child = $row->getStudent;
            if ($child->status === 'Active') {
                $ar['rel'] [] = [
                    'name' => $child->name,
                    'key' => $child->id,
                    'notice' => 'Sebagai ' . $row->get_hub->ind,
                    'status' => TYPE_USER[3]
                ];
            };
        }
        return $ar;
    }

    private function checkStatusHub($model)
    {
        $checkUser = $this->getOneHub()->user_id;
        return [
            'notice' => $checkUser ? 'Aktif' : 'Belum Terdaftar',
            'date' => $checkUser ? $this->getOneHub()->getUser->created_at : null
        ];
    }

    private function addiEmail($model)
    {
        return [
            'email' => $model->email
        ];
    }

    private function checkStatusUser($model)
    {
        return [
            'notice' => $model->deleted_at ? STATUS_USER[0] : STATUS_USER[1],
            'date' => $model->deleted_at ? $model->deleted_at : $model->created_at
        ];
    }

    private function checkStatusStudent($model)
    {
        $KEY = $model->status;
        $date = Carbon::createFromFormat('Y-m-d', $model->register)->addDays(30);
        return [
            'notice' => STATUS_USER[1] === STATUS_STUDENT[$KEY] ? (now()->gt($date) ? STATUS_USER[2] : STATUS_USER[1]) : STATUS_USER[0],
            'date' => $date
        ];
    }

    private function additionalStudent($model)
    {
        $ar = [];

        $ar['needed'] = $this->getNeeded($model->getDisablity);
        $ar['desc'] = $model->detail;

        if ($families = $this->getFamily($model->getFams)) {
            $ar['rel'] = $families;
        }

        return $ar;
    }

    private function getFamily($model)
    {
        $ar = [];
        foreach ($model as $row) {
            $ar[] = [
                'key' => $row->id,
                'name' => $row->getFami->name,
                'notice' => $row->get_hub->ind,
                'status' => TYPE_USER[4]
            ];
        }
        return $ar;
    }


}