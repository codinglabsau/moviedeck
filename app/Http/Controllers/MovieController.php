<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use App\Models\Genre;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'DESC')
            ->paginate(20);

        foreach($movies as $movie) {
            $movie->average_rating = round($movie->reviews()->average('rating'),1);
        }

        return view('movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        $genres = Genre::all();
        $celebs = Celeb::orderBy('name', 'ASC')->get();

        return view('movies.create', [
            'genres' => $genres,
            'celebs' => $celebs
        ]);
    }

    public function store(MovieRequest $request)
    {
        $movie = Movie::create($request->except('genres', 'celebs', 'characters'));

        $genres = $request->input('genres');
        $movie->genres()->sync($genres);

        $results = array_combine($request->input('celebs'), $request->input('characters'));
        $casts = collect($results)
            ->map(function($result) {
                return ['character_name' => $result];
            });
        $movie->celebs()->sync($casts);

        return redirect()->route('movies.index')
            ->with(['message' => 'Success! Movie has been added.']);
    }

    public function show(Movie $movie)
    {
        $movie->with([
            'genres',
            'celebs'
        ])->get();

        $movie->average_rating = round($movie->reviews()->average('rating'),1);

        $reviews = $movie->reviews()->paginate(3);

        return view('movies.show', [
            'movie' => $movie,
            'rating' => $movie->average_rating,
            'reviews' => $reviews
        ]);
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::all();
        $celebs = Celeb::orderBy('name', 'ASC')->get();

        return view('movies.edit', [
            'movie' => $movie,
            'genres' => $genres,
            'celebs' => $celebs
        ]);
    }

    public function update(MovieRequest $request, Movie $movie)
    {
        $movie->update($request->except('genres', 'celebs', 'characters'));

        $genres = $request->input('genres');
        $movie->genres()->sync($genres);

        $results = array_combine($request->input('celebs'), $request->input('characters'));
        $casts = collect($results)
            ->map(function($result) {
                return ['character_name' => $result];
            });
        $movie->celebs()->sync($casts);

        return redirect()->route('movies.show', $movie)
            ->with(['message' => 'Success! Movie has been updated.']);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')
            ->with(['message' => 'Success! Movie has been deleted.']);
    }
}
