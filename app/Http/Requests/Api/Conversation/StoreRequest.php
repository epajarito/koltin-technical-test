<?php

namespace App\Http\Requests\Api\Conversation;

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
            'user_id_receiver' => [
                'bail',
                'required',
                'int',
                'exists:users,id',
            ],
            'user_id_sender' => 'bail|required|int|exists:users,id',
            'post_id' => 'bail|required|int|exists:posts,id',
        ];
    }
}
