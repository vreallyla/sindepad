<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 16/10/2018
 * Time: 14:56
 */

namespace App\DeclaredPDO\Additional;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;

trait plugClass
{
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
     * checking multiple array key exist
     * @param $key_array
     * @param $content
     * @return bool
     */
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

    protected static function check_file($asset)
    {
        return \Illuminate\Support\Facades\File::exists($asset) ? $asset : asset('images/img_unvailable.png');
    }
    protected static function check_file_bool($asset)
    {
        return \Illuminate\Support\Facades\File::exists($asset) ? $asset :false;
    }

    protected static function validates($r,$rule,$notice)
    {
        $validator = Validator::make($r, $rule,$notice);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    }

    /**
     * get public to find in storage
     * @param $url
     * @return string
     */
    protected static function slice_storage($url)
    {
        return substr($url,7);
    }

    /**
     * make storage available on public
     * @param $url
     * @return string
     */
    protected static function slice_public($url)
    {
        return 'storage'.substr($url,6);

    }

    /**
     * checking an array from the object
     * also selection some array
     * @param $selection
     * @param $ar
     * @return array|bool
     */
    public function choose_array($selection, $ar)
    {
        $arr = array();
        foreach ($selection as $row) {
            array_key_exists($row, $ar) ? $arr[$row] = $ar[$row] : $arr[$row] = '';
            if (!$arr[$row]) {
                return false;
                break;
            }
        }

        return $arr;
    }

}