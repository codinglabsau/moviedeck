<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'between:4,30',
                Rule::unique('users')->ignore($this->user)
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'avatar' => [
                'required',
                'max:255'
            ],
            'about_me' => [
                'max:200'
            ]
        ];
    }
}
