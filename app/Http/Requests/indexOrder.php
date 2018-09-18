<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class indexOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.*' => 'required',
            'sex.*' => 'required|exists:side_genders,id',
            'course.*' => 'required|exists:mst_classes,id',
            'relligion.*' => 'required|in:Islam,Non Muslim',
            'rs.*' => 'required|in:Orang Tua,Wali,Lainnya',
            'needed.*' => 'required|exists:mst_disabilities,id',
            'desc.*' => 'required'
        ];
    }
}
