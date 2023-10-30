<?php

namespace App\Http\Requests\Words;

use Illuminate\Foundation\Http\FormRequest;

class WordsRequest extends FormRequest
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
            'ws_name' => 'required',
            'ws_definition' => 'sometimes',
            'ws_pronunciation' => 'sometimes',
            'ws_slogan' => 'sometimes',
            'ws_description' => 'sometimes',
            'ws_is_important' => 'sometimes',
            'ws_is_common' => 'sometimes',
            'ws_forget_count' => 'sometimes',
            'ws_order' => 'sometimes',
            'cate_id' => 'sometimes',
            'wordsTags' => 'sometimes|array',
            'testCol' => 'required'
        ];
    }
}
