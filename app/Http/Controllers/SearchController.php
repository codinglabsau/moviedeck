<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Celeb;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, User $user) {
        $keyword = $request->input('search');

        $movies = Movie::query()
            ->select('id', 'title', 'poster')
            ->when($keyword, function ($q) use ($keyword){
                $q->where('title', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('title')
            ->paginate(5);

        $celebs = Celeb::query()
            ->select('id', 'name', 'photo')
            ->when($keyword, function ($q) use ($keyword){
                $q->where('name', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('name')
            ->paginate(5);


        return view('search', [
            'keyword' => $keyword,
            'movies' => $movies,
            'celebs' => $celebs,
            //'user' => $user
        ]);
    }
}
