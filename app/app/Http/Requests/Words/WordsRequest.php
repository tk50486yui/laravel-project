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
            'ws_is_important' => 'sometimes|nullable|boolean',
            'ws_is_common' => 'sometimes|nullable|boolean',
            'ws_forget_count' => 'sometimes|nullable|integer|min:0',
            'ws_order' => 'sometimes|nullable|integer|min:0',
            'cate_id' => 'sometimes|nullable|integer|min:1', // 外鍵
            /*
                "words_tags":{ "array" : [], "values": [] }
                欲新增的資料 (ts_id) 依序放進 "array" 就好
            */
            'words_tags' => 'sometimes|nullable'
        ];
    }
}
