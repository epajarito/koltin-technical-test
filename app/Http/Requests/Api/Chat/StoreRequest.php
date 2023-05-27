<?php

namespace App\Http\Requests\Api\Chat;

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
            'message' => 'bail|required|string|max:256',
            'user_id' => 'bail|required|int|exists:users,id',
            'conversation_id' => 'bail|required|int|exists:conversations,id',
            'file' => 'bail|nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,mp3,m4a|max:5120'
        ];
    }
}
