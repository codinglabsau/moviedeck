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
        $movies = Movie::orderBy('id', 'DESC')->paginate(20);

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
        dd($request);
        $movie = Movie::create($request->validated());

        $genres = $request->input('genres');
        $movie->genres()->sync($genres);

//        $celebs = $request->input('celebs');
//        $character = $request->input('character_name');
//        $movie->celebs()->sync($celebs, ['character_name' => $character]);

       $celebs = collect($request->input('celebs', []))
           ->map(function($celeb) {
               return ['character_name' => $celeb];
           });

       $movie->celebs()->sync($celebs);

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
