<?php

namespace App\Http\Requests\Api\Message;

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
            'message' => 'required|string',
            'user_id_sender' => 'required|int|exists:users,id',
            'user_id_receiver' => 'required|int|exists:users,id',
            'post_id' => 'required|int|exists:posts,id',
            'file' => 'bail|nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,mp3,m4a|max:5120'
        ];
    }
}
