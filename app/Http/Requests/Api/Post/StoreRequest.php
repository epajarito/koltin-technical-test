<?php

namespace App\Http\Requests\Api\Post;

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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'description' => 'required|string',
            'image' => 'required|file|max:1024',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'image.max' => "Debes seleccionar una imagen de almenos 1024 kb"
        ];
    }
}
