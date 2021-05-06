<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        $review = $request->route('review');

        if (isset(auth()->user()->id) && auth()->user()->id != $review->user_id)
        {
            redirect()->route('reviews.show', $review->id)
                ->with('status', 'Oops! You do not have permission to edit this review.');

            return false;

        } else {

            return true;
        }
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
