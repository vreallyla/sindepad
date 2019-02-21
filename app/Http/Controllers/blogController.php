<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\imgParallax;
use App\DeclaredPDO\Jwt\extraClass;
use App\DeclaredPDO\Jwt\jwtClass;
use App\Model\_activities\mstActivity;
use App\DeclaredPDO\allNeeded as Selingan;
use App\Model\Admin\news\MstNewsList;
use App\Model\Admin\news\sideNewsCategory;
use Illuminate\Http\Request;

class blogController extends Controller
{
    use extraClass;

    public function index(Request $r)
    {

        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';
        $parralax = imgParallax::getImgN();
        $dataN = self::convertToObject([
            'data' => $this->dataN($r),
            'cat' => $this->cat(),
            'search' => $r->has('q') ? $r->q : null
        ]);


        return view('blog.all', compact('default', 'title', 'menu', 'user_cookie', 'parralax', 'dataN'));
    }

    public function single(Request $r,$blog)
    {
        $user_cookie = $r->data;
        $default = Selingan::index('Program');
        $title = 'Daftar Program Kelas';
        $menu = 'Program';
        $parralax = imgParallax::getImgN();
        $dataN = self::convertToObject([
            'data'=>MstNewsList::findOrFail($blog),
            'cat' => $this->cat(),
            'search' => $r->has('q') ? $r->q : null
        ]);

        return view('blog.single', compact('default', 'title', 'menu', 'user_cookie', 'parralax', 'dataN'));
    }


    private function dataN($r)
    {
        $data = MstNewsList::when($r->date, function ($query) use ($r) {
             return $query->whereDate('created_at','<=', $r->date);
        })
            ->when($r->cat, function ($query) use ($r) {
                 $query->wherehas('getRel', function ($rel) use ($r) {
                    $rel->where('category_id', $r->cat)
                        ->when($r->q, function ($query2) use ($r) {
                        return  $query2->where('name', 'LIKE', '%' . $r->q . '%')->orWhere('desc', 'LIKE', '%' . $r->q . '%');
                    });
                });
            })->orderBy('created_at', 'desc')->paginate(6);

        return $data;
    }

    private function cat()
    {
        return sideNewsCategory::orderBy('name', 'asc')->get();
    }


}
