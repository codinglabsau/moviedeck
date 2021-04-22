<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CelebRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'date_of_birth' => ['required'],
            'photo' => ['required'],
        ];
    }
}
