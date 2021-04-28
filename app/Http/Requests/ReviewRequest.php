<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'user_id' => ['required'],
            'movie_id' => ['required'],
            'title' => [
                'required',
                'string',
                'min:10',
                'max:255'
            ],
            'rating' => [
                'required',
                'numeric',
                'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'min:0.1',
                'max:10'
            ],
            'content' => [
                'required',
                'string',
                'min:30'
            ]
        ];
    }
}
