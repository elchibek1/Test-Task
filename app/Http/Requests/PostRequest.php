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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'text' => ['required', 'min:5', 'max:200', "not_regex:([?:\"[^\"]*\"['\"]*|'[^']*'['\"]*|[^'\">]])"],
            'user_id' => ['required'],
            'picture' => ['image']
        ];
    }
}
