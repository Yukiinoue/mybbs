<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'name' => 'required',
            'body' => 'required',
            'password' => 'required|between: 4,32',
            'posted_at' => 'required',
            'files' => 'sometimes|array|max:3',
            'files.*' => 'sometimes|max:40960|mimes:jpeg,gif,png,mp4,quicktime',
        ];
    }
}
