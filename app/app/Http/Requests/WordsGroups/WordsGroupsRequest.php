<?php

namespace App\Http\Requests\WordsGroups;

use Illuminate\Foundation\Http\FormRequest;

class WordsGroupsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wg_name' => 'required',
            'words_groups_datails' => 'required|array'
        ];
    }
}
