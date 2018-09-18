<?php

namespace App\Http\Controllers\Api;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\indexOrder;
use App\Model\sideGender;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

const types = ['name', 'sex', 'relligion', 'course', 'rs', 'needed', 'desc'];

class OrderController extends Controller
{
    public $error = array();

    public function first(Request $r)
    {
        $this->validate($r, [
            'name.*' => 'required',
            'sex.*' => 'required|exists:side_genders,id',
            'course.*' => 'required|exists:mst_classes,id',
            'relligion.*' => 'required|in:Islam,Non Muslim'
        ]);

//        $this->setSession($r);

        return response()->json('asdasd');
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
        $valid = $this->koreksi([
            'name' => [
                'required' => [],
                'val' => $r->only('name')
            ],
            'sex' => [
                'required' => [],
                'exists' => [
                    'db' => 'side_genders',
                    'column' => 'id'
                ],
                'val' => $r->only('sex')
            ]
        ]);


        return response()->json($this->error);
    }

    public function koreksi($arr)
    {
        foreach ($arr as $name => $val) {
            foreach ($val as $key => $content) {
                $this->opsiCorrect($key, $val['val'], $name, $content);
            }
        }

    }

    public function opsiCorrect($key, $val, $name, $content)
    {
        switch ($key) {
            case 'required':
                if (is_array($val)) {
                    if (!array_key_exists($name, $val)) {
                        $this->requiredFalse($name, 0);
                    } else {
                        foreach ($val[$name] as $index => $row) {
                            $this->requiredCorect($name, $row, $index);
                        }
                    }
                } else {
                    $this->requiredCorect($name, $val, 0);
                }
                break;
            case 'exists:':
//                if (is_array($val)) {
//                    if (!array_key_exists($name, $val)) {
//                        $this->existFalse($key, 0);
//                    } else {
//                        foreach ($val[$name] as $index => $row) {
//                            $this->existCorrect($name, $row, $index, $content);
//                        }
//                    }
//                } else {
////                    $this->existCorrect($name, $val, 0, $content);
//                }
                $this->error[$name] = 'aaaa';
                break;

            case 'in:':
                break;
            default:
                break;
        }
    }

    public function requiredCorect($key, $val, $index)
    {
        $determinant = self::min(1, $val);

        if ($determinant) {
            if (!array_key_exists($key, $this->error)) {
                $this->error[$key] = array();
            }
            $this->requiredFalse($key, $index);
        }
    }

    public function requiredFalse($key, $index)
    {
        $this->error[$key][] = [
            'msg' => 'harap isi colom diatas',
            'index' => $index
        ];
    }

    public function existCorrect($name, $val, $index, $content)
    {

    }

    public function existFalse($key, $index)
    {
        $this->error[$key][] = [
            'msg' => 'harap tidak merubah data yang ada',
            'index' => $index
        ];
    }

    private static function min($val, $r)
    {
        if (strlen($r) < $val) {
            return 'input minimal ' . $val . ' huruf';
        }
    }

    private function max($val, $r, $obj)
    {
        if ($r < $val) {
            return response()->json(['obj' => $r, 'maksimal input ' . $obj . ' huruf'], 500);
        }
    }

}
