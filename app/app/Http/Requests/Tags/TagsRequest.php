<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class TagsRequest extends FormRequest
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
            'ts_name' => 'required',
            'ts_storage' => 'sometimes',
            'ts_parent_id' => 'sometimes',
            'ts_level' => 'sometimes',
            'ts_order' => 'sometimes',
            'ts_description' => 'sometimes',          
            'testCol' => 'required'
        ];
    }
}
