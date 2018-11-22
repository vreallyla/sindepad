<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 15/10/2018
 * Time: 17:12
 */

namespace App\DeclaredPDO\Jwt;


use App\DeclaredPDO\Additional\plugClass;
use App\Model\mstDataPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


trait extraClass
{
    use plugClass;

    /**
     * checking user cookie exist
     * if cookie condition null return false
     * @return array|bool|mixed
     */
    public static function check_user($name, $url)
    {
//        if ($data = self::checkCookie() ? self::get_cookie_array() : false) {

//            if (is_array($data) && self::multi_exist(['name', 'token'], $data)) {
        $short = self::cookie_modify($name, $url);
        return self::convertToObject($short);
//            }

//            self::remove_cookie($data, 59);
//
//        }
//
//        return false;
    }

    /**
     * get the cookie as stdclass
     * this funct for get user datas
     * datas are token,url,name
     * @return mixed
     */
    public static function get_cookie()
    {
        return Session::get('uzanto');
    }

    /**
     * get the cookie as array
     *
     * @return mixed
     */
    protected static function get_cookie_array()
    {
        return json_decode(json_encode(Session::get('uzanto')), true);
    }

    /**
     * check the cookie token exist.
     * uzanto is name cookie for the jwt datas
     *
     * @return bool
     */
    public static function checkCookie()
    {
        return Session::has('uzanto') ? true : false;
    }


    /**
     * @param Request $r
     * route from /kreu-token
     * making cookie after login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cookie_token(Request $r)
    {
        $this->cookie_decode($r->only('token', 'name', 'url'));
        $data = self::cookie_modify($r->name, $r->url);
        $data['token'] = $r->token;
        return response()->json($data);
    }

    /**
     * shorting cookie name & make url
     * @param $name
     * @param $url
     * @return mixed
     */
    protected static function cookie_modify($name, $url)
    {
        $object = self::check_char($name, ' ');
        $data['name'] = !empty($object) ? self::string_slice($name, 0, $object) : $name;
        $data['url'] = self::check_file($url);

        return $data;
    }

    /**
     * making a cookie
     *
     * @param $val
     * @param $time
     */
    private function cookie_decode($val)
    {
        Session::put('uzanto', self::convertToObject($val));
    }

    /**
     * remove a cookie
     *
     * @param $val
     * @param $time
     */
    private static function remove_cookie()
    {
        Session::forget('uzanto');

    }

    /**
     * logout proccess
     */
    public function logout_now()
    {
        self::remove_cookie();
        $this->guard()->logout();

        return 'berhasil keluar';
    }

    private function changeThousand($val)
    {
        return is_float($val)? number_format($val,1,',','.'):number_format($val,0,',','.');
    }

    private function getId()
    {
        return Auth::guard('api')->user();
    }

    private function noticeNull(){
        return response()->json(['msg'=>'data kosong'],403);

    }
    private function noticechangeData()
    {
        return response()->json(['msg'=>'Harap tidak mengganti data'],405);
    }

    private function notFound()
    {
        return response()->json(['msg'=>'Data tidak ditemukan'],404);
    }



}