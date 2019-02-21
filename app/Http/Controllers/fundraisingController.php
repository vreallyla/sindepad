<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\imgParallax;
use App\DeclaredPDO\Jwt\extraClass;
use App\Model\Peng\mstPengDana;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;


class fundraisingController extends Controller
{
    use extraClass;

    public function index(Request $r)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $title = 'Daftar Bantuan';
        $menu = 'Daftar';
        $parralax = imgParallax::getImgN();
        $dataN = self::convertToObject([
            'data' => $this->dataN($r),
            'search' => $r->has('q') ? $r->q : null
        ]);


        return view('fundraising.index', compact('default', 'title', 'menu', 'user_cookie', 'parralax', 'dataN'));
    }

    public function single(Request $r,$key)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $menu = 'Detail';
        $parralax = imgParallax::getImgN();
        $dataN = self::convertToObject([
            'data'=>mstPengDana::findOrFail($key),
            'search' => $r->has('q') ? $r->q : null
        ]);
        $title = $dataN->data->name;


        return view('fundraising.detail', compact('default', 'title', 'menu', 'user_cookie', 'parralax', 'dataN'));
    }

    public function sendPost(Request $r)
    {
        
    }

    private function dataN($r)
    {
        $data = mstPengDana::when($r->date, function ($query) use ($r) {
            return $query->whereDate('created_at', '<=', $r->date)
                ->when($r->q, function ($query2) use ($r) {
                    return $query2->where('name', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('target', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('desc', 'LIKE', '%' . $r->q . '%')
                        ->orWhere('kode', 'LIKE', '%' . $r->q . '%');
                });
        })->orderBy('created_at', 'desc')->paginate(6);

        return $data;
    }
}
