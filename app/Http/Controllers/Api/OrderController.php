<?php

namespace App\Http\Controllers\Api;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\indexOrder;
use App\Model\sideGender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use App\DeclaredPDO\relation as Hubungan;


const types = ['name', 'sex', 'relligion', 'course', 'rs', 'needed', 'desc'];

class OrderController extends Controller
{
    public $error = array();

    private $correct=array();

    private $validar=array();


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
            ],
            'rs' => [
                'required' => [],
                'in' => Hubungan::index(),
                'val' => $r->only('rs')
            ]
        ]);

        $colussion= $valid ? $valid : $this->store($r);

        return response()->json($this->error);
    }

    public function validarOrdre()
    {
        if (!Auth::guest()){

        }
        else{

        }
    }

    public function koreksi($arr)
    {
        foreach ($arr as $name => $val) {
            foreach ($val as $key => $content) {
                $this->opsiCorrect($key, $val['val'], $name, $content);
            }
        }

    }

    public function orderExist()
    {
        
    }

    private function stdDades()
    {
    }

    function store(Request $request) {

        try {
            // my data storage location is project_root/storage/app/data.json file.
            $contactInfo = Storage::disk('local')->exists('data.json') ? json_decode(Storage::disk('local')->get('data.json')) : [];

            $inputData = $request->only(['name', 'email', 'message','subject']);

            $inputData['datetime_submitted'] = date('Y-m-d H:i:s');

            array_push($contactInfo,$inputData);

            Storage::disk('local')->put('data.json', json_encode($contactInfo));

            return $inputData;

        } catch(\Exception $e) {

            return ['error' => true, 'message' => $e->getMessage()];

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
            case 'exists':
                if (is_array($val)) {
                    if (array_key_exists($name, $val)) {
                        foreach ($val[$name] as $index => $row) {
                            $this->existCorrect($name, $row, $index, $content);
                        }
                    }
                } else {
                    $this->existCorrect($name, $val, 0, $content);
                }
                break;

            case 'in':
                if (is_array($val)) {
                    if (array_key_exists($name, $val)) {
                        foreach ($val[$name] as $index => $row) {
                            $this->inCorrect($name, $row, $index, $content);
                        }
                    }
                } else {
                    $this->inCorrect($name, $val, 0, $content);
                }
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
        $data = DB::table($content['db'])->where($content['column'], $val)->first();

        if (!$data) {
            $this->existFalse($name, $index);
        }

    }

    public function existFalse($key, $index)
    {
        $this->error[$key][] = [
            'msg' => 'harap tidak merubah data yang ada',
            'index' => $index
        ];
    }

    public function inCorrect($name, $val, $index, $content)
    {
        if (!in_array($val, $content['id'])) {
            $this->existFalse($name, $index);
        }
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
