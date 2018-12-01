<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 29/11/2018
 * Time: 1:22
 */

namespace App\DeclaredPDO;


use App\Model\sideStatusUser;
use Illuminate\Support\Facades\File;


trait response
{
    private function noticeNull()
    {
        return response()->json(['msg' => 'data kosong'], 403);

    }

    private function noticeFail()
    {
        return response()->json(['msg' => 'Gagal dibuat'], 406);

    }private function noticeSuc()
    {
        return response()->json(['msg' => 'berhasil dibuat'], 200);

    }

    private function noticechangeData()
    {
        return response()->json(['msg' => 'Harap tidak mengganti data'], 405);
    }

    private function notFound()
    {
        return response()->json(['msg' => 'Halaman tidak ditemukan'], 404);
    }

    private function checkImg($img)
    {
        return File::exists($img) ? asset($img) : asset('images/img_unvailable.png');
    }

    private function getNeeded($rel)
    {
        $str = '';
        foreach ($rel as $row) {

            $str .= $row->getDetailDis->name . ', ';
        }
        return $str ? substr($str, 0, -2) : '';

    }

    private function niSet($model, $code)
    {
        do {
            $kode = $code . now()->format('ym') . sprintf("%04d", rand(0001, 9999));
        } while (!$model->where('ni', $kode)->get());

        return $kode;
    }

    private function getUserStatus($role)
    {
        $status = sideStatusUser::where('ind', $role)->first();

        if (isset($status)) {
            return $status->id;
        }

    }
}