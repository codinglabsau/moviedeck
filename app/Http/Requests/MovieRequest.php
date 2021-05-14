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
        return auth()->check() && auth()->user()->is_admin;
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
                'min:1888',
                'max:'.date('Y'),
            ],
            'poster' => [
                'required',
                'url'
            ],
            'banner' => [
                'required',
                'url'
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
            'genres' => [
                'required',
                'array'
            ],
//            'celebs.*' => [
//                'string',
//                'max: 30'
//            ],
//            'celebs' => [
//                'required',
//                'array'
//            ],
        ];
    }
}
