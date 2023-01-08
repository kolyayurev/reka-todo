<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CardRequest extends BaseRequest
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
            'description' => 'nullable|string|max:1024',
            'photo' => 'nullable|string|max:255', 
            'list_id' => 'required|numeric', 
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
            'description' => 'Описание',
            'photo' => 'Фотография',
            'list_id' => 'Список',
        ];
    }
}
