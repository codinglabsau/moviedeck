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

    public function show(Movie $movie, Review $review)
    {
        $review->with('movie:id,title,poster,trailer')->get();

        return view('reviews.show', [
            'movie' => $movie,
            'review' => $review
        ]);
    }

    public function create(Movie $movie)
    {
        return view('reviews.create', [
            'movie' => $movie
        ]);
    }

    public function store(Store $request, Movie $movie)
    {
        Review::create($request->validated());

        return redirect()->route('reviews.index')
            ->with('message', 'Success! Review has been added.');
    }

    public function edit(Movie $movie, Review $review)
    {
        if (request()->user()->id === $review->user->id)
        {
            return view('reviews.edit', [
                'movie' => $movie,
                'review' => $review
            ]);
        }

        return redirect()->route('reviews.show', ['movie' => $movie, 'review' => $review])
            ->with('message', 'Oops! You do not have permission to edit this review.');
    }

    public function update(Update $request, Movie $movie, Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('reviews.show', ['movie' => $movie, 'review' => $review])
                ->with('message', 'Success! Review has been updated.');
    }

    public function destroy(Movie $movie, Review $review)
    {
        if ($review->user->id === request()->user()->id || request()->user()->is_admin)
        {
            $review->delete();

            return redirect()->route('reviews.index')
                ->with('message', 'Success! Review has been deleted.');
        }

        return redirect()->route('reviews.show', ['movie' => $movie, 'review' => $review])
            ->with('message', 'Oops! You do not have permission to delete this review.');
    }
}
