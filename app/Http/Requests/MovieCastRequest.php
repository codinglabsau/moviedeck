<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieCastRequest extends FormRequest
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
            'celebs.*' => [
                'string',
                'max: 30'
            ],
            'celebs' => [
                'required',
                'array'
            ],
        ];
    }
}
