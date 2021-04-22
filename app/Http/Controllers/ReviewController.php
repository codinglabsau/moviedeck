<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['movie'])
            ->latest()
            ->paginate(20);

        return view('reviews.index', [
            'reviews' => $reviews
        ]);
    }

    public function show(Review $review)
    {
        $review->with([
            'movie'
        ])->get();

        return view('reviews.show', [
            'review' => $review
        ]);
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(ReviewRequest $request)
    {
        Review::create($request->validated());
    }

    public function edit(Review $review)
    {
        return view('reviews.edit', ['review' => $review]);
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
    }

    public function destroy(Review $review)
    {
        $review->delete();
    }
}
