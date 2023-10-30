<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
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
            'arti_title' => 'required',
            'arti_content' => 'sometimes',
            'arti_order' => 'sometimes',
            'cate_id' => 'sometimes',          
            'testCol' => 'required'
        ];
    }
}
