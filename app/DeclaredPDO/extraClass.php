<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 15/10/2018
 * Time: 17:12
 */

namespace App\DeclaredPDO;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;

trait extraClass
{

    /**
     * checking user cookie exist
     * if cookie condition null return false
     * @return array|bool|mixed
     */

    public static function check_user()
    {
        if ($data = self::checkCookie() ? self::get_cookie_array() : false) {

            if (is_array($data) && self::multi_exist(['name', 'token'], $data)) {
                $short = self::cookie_modify($data['name'], $data['url']);
                return self::convertToObject($short);
            }

            self::remove_cookie($data, 59);

        }

        return false;
    }

    protected static function multi_exist($key_array, $content)
    {
        foreach ($key_array as $row) {
            if (!array_key_exists($row, $content)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $content = data
     * @param $from = start string by string index
     * @param $end = end string by string index
     * @return bool|string = checking data
     */
    public static function string_slice($content, $from, $end)
    {
        return substr($content, $from, $end);
    }

    /**
     * @param $content = data
     * @param $pos = index object that search
     * @return bool|int = checking data
     */
    public static function check_char($content, $pos)
    {
        return strpos($content, $pos);
    }


    /**
     * get the cookie as stdclass
     * this funct for get user datas
     * datas are token,url,name
     * @return mixed
     */
    public static function get_cookie()
    {
        return json_decode(Cookie::get('uzanto'));
    }

    /**
     * get the cookie as array
     *
     * @return mixed
     */
    protected static function get_cookie_array()
    {
        return json_decode(Cookie::get('uzanto'), true);
    }

    /**
     * check the cookie token exist.
     * uzanto is name cookie for the jwt datas
     *
     * @return bool
     */
    public static function checkCookie()
    {
        return (Cookie::has('uzanto') ? true : false);
    }

    /**
     * @param $array
     *  convert array into stdclass
     * @return \stdClass
     */
    static function convertToObject($array)
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

    /**
     * @param Request $r
     * route from /kreu-token
     * making cookie after login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cookie_token(Request $r)
    {

        $this->cookie_decode($r->only('token', 'name', 'url'), 59);

        return response()->json(self::cookie_modify($r->name, $r->url));
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
        $asset = asset($url);
        $data['name'] = !empty($object) ? self::string_slice($name, 0, $object) : $name;
        $data['url'] = File::exists($asset) ? $asset : asset('images/img_unvailable.png');

        return $data;
    }

    /**
     * making a cookie
     *
     * @param $val
     * @param $time
     */
    private function cookie_decode($val, $time)
    {
        Cookie::queue('uzanto', json_encode($val), $time);
    }

    /**
     * remove a cookie
     *
     * @param $val
     * @param $time
     */
    private static function remove_cookie($val, $time)
    {
        Cookie::queue('uzanto', json_encode($val), $time);
        Cookie::queue('uzanto', json_encode($val), -$time);
    }

}