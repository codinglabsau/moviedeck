<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();

        return view('movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Movie $movie)
    {
        $movie->with([
            'genres',
            'celebs',
            'reviews'
        ])->get();

        return view('movies.show', [
            'movie' => $movie,
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
