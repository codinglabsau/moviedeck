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
            'celebs.*' => [
                'required',
            ],
            'celebs' => [
                'required',
                'array'
            ],
            'characters.*' => [
                'required',
                'string',
                'max: 30'
            ],
            'characters' => [
                'required',
                'array'
            ],
        ];
    }

    public function messages() {
       return [
           'genres.required' => 'Select one or more genres.',
           'celebs.required' => 'Add one or more casts.',
           'characters.required' => 'Add one or more casts.',
           'celebs.*.required' => 'Select the appropriate celebrity.',
           'characters.*.required' => 'Add the character name.',
           'characters.*.string' => 'Cast name must be a string',
           'characters.*.max' => 'Cast name must not be more than 30 characters.',
       ];
    }
}
