<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'min:5'
                ],
            'synopsis' => [
                'required',
                'string',
                'min:30'
                ],
            'year' => [
                'required',
                'integer',
                'min:'.date('Y'),
                'size:4'
            ],
            'poster' => [
                'required',
                'mimes:jpg,png,jpeg',
                'max:5048'
            ],
            'banner' => [
                'required',
                'mimes:jpg,png,jpeg',
                'max:5048'
            ],
            'trailer' => [
                'required',
                'url'
            ],
            'duration' => [
                'required',
                'integer',
                'between:50,300'
            ],
        ];
    }
}
