<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Celeb;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        $search = $request->input('search');
        $switch = $request->input('switch');

        if($switch === 'movies') {
            $results = Movie::query()
                ->select('id', 'title', 'poster')
                ->where('title', 'LIKE', "%{$request->query('search')}%")
                ->orderBy('title')
                ->paginate(10);
        } else {
            $results = Celeb::query()
                ->select('id', 'name', 'photo')
                ->where('name', 'LIKE', "%{$request->query('search')}%")
                ->orderBy('name')
                ->paginate(10);
        }

        return view('search', [
            'search' => $search,
            'switch' => $switch,
            'results'  => $results->appends(['search' => $search, 'switch' => $switch]),
        ]);
    }
}
