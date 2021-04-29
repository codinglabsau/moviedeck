<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(20);

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
//        if($request->has('poster') && $request->has('banner')) {
//            $posterImage = time() . '-' . $request->poster->getClientOriginalName();
//            $bannerImage = time() . '-' . $request->banner->getClientOriginalName();
//
//            $request->poster->move(public_path('images/movies/posters'), $posterImage);
//            $request->banner->move(public_path('images/movies/banners'), $bannerImage);
//
//            dd($posterImage);
//        }
        if($request->has('poster')) {
            $posterImage = time() . '-' . $request->poster->getClientOriginalName();

            $request->poster->move(public_path('images/movies/posters'), $posterImage);
        }

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
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
    }
}
