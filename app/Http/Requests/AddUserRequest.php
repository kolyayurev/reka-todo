<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class AddUserRequest extends BaseRequest
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
            'email' => ['bail','required', 'email',Rule::notIn([auth()->user()->email]),'exists:users'], 
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
            'exists' => 'Такого пользователя нет',
            'not_in' => 'Вы не можете добавить сами себя',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'E-mail',
        ];
    }
}
