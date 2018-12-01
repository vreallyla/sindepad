<?php

namespace App\Http\Controllers\Api\Admin\settings;

use App\DeclaredPDO\Jwt\extraClass;
use App\sideNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class aggrementController extends Controller
{
    use extraClass;

    public function post(Request $r)
    {
        try {
            sideNote::where('status','Active')->update([
                'status' => 'Non Active'
            ]);
            sideNote::create([
                'detail' => $r->detail,
                'status' => 'Active'
            ]);

        } catch (\Exception $er) {
            return $this->noticeFail();
        }

        return $this->noticeSuc();
    }
}
