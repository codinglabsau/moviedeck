<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Http\Requests\Review\Store;
use App\Http\Requests\Review\Update;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('movie:id,title,poster,trailer')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('reviews.index', [
            'reviews' => $reviews
        ]);
    }

    public function show(Review $review)
    {
        $review->with('movie:id,title,poster,trailer')->get();

        return view('reviews.show', [
            'review' => $review
        ]);
    }

    public function create(Movie $movie)
    {
        return view('reviews.create', [
            'movie' => $movie
        ]);
    }

    public function store(Store $request)
    {
        Review::create($request->validated());

        return redirect()->route('reviews.index')
            ->with('status', 'Success! Review has been added.');
    }

    public function edit(Review $review)
    {
        if (isset(auth()->user()->id) && auth()->user()->id != $review->user_id)
        {
            return redirect()->route('reviews.show', $review)
                    ->with('status', 'Oops! You do not have permission to edit this review.');
        } else {
            return view('reviews.edit', [
                'review' => $review
            ]);
        }
    }

    public function update(Update $request, Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('reviews.show', $review)
                ->with('status', 'Success! Review has been updated.');
    }

    public function destroy(Review $review)
    {
        if (!(auth()->user()->is_admin) || auth()->user()->id == $review->user_id)
        {
            return redirect()->route('reviews.show', $review)
                ->with('status', 'Oops! You do not have permission to delete this review.');
        } else {
            $review->delete();

            return redirect()->route('reviews.index')
                ->with('status', 'Success! Review has been deleted.');
        }
    }
}
