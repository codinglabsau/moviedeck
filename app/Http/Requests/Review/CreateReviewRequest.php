<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

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
