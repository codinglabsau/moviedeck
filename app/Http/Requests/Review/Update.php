<?php

namespace App\Http\Requests\Review;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function authorize(Request $request)
    {
        $review = $request->route('review');

        if (request()->user()->id !== $review->user->id)
        {
            redirect()->route('reviews.show', ['movie' => $review->movie_id, 'review' => $review->id])
                ->with('status', 'Oops! You do not have permission to edit this review.');

            return false;
        }

        return true;
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
