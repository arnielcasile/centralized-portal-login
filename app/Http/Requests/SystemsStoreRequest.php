<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SystemsStoreRequest extends FormRequest
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
            'name'              => ['required',Rule::unique('systems')->ignore($this->route('id'))],
            'reference_code'    => ['required',Rule::unique('systems')->ignore($this->route('id'))],
            'reference_number'  => ['required',Rule::unique('systems')->ignore($this->route('id'))],
            'description'       => 'required',
            'url'               => 'required|url',
            'date_deployed'     => 'required|date_format:Y-m-d',
            'status'            => 'required',
            'section_owner'     => 'required',
            'abbreviation'      => 'required',
        ];
    }
}
