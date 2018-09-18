<?php

namespace App\Http\Controllers;

use App\Http\Requests\indexOrder;
use App\Model\sideGender;
use Illuminate\Http\Request;

const types = ['name', 'sex', 'relligion', 'course', 'rs', 'needed', 'desc'];

class orderController extends Controller
{


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

    }


}
