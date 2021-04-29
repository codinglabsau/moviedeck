<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'DESC')->paginate(20);

        return view('movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(MovieRequest $request)
    {
        Movie::create($request->validated());

        return redirect()->route('movies.index')
            ->with(['message' => 'Your movie has been added.']);
    }

    public function show(Movie $movie)
    {
        $movie->with([
            'genres',
            'celebs',
        ])->get();

        $reviews = $movie->reviews()->paginate(2);

        return view('movies.show', [
            'movie' => $movie,
            'reviews' => $reviews
        ]);
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit', ['movie' => $movie]);
    }

    public function update(MovieRequest $request, Movie $movie)
    {
        $movie->update($request->validated());

        return redirect()->route('movies.index')
            ->with(['message' => 'Your movie has been updated.']);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')
            ->with(['message' => 'Your movie has been deleted.']);
    }
}
