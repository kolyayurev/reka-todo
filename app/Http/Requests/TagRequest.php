<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TagRequest extends BaseRequest
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
            'name' => 'required|string|max:255', 
            'board_id' => 'required|numeric', 
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Имя',
            'board_id' => 'Доска',
        ];
    }
}
