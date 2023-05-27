<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|string|max:15'
        ];
    }


    public function messages()
    {
        return [
            'email.unique' => "El correo ya esta en uso",
            'name.max' => "El campo nombre debe de contener no mas de 30 caracteres",
            'password.max' => "El contraseña debe de contener no mas de 15 caracteres",
        ];
    }
}
