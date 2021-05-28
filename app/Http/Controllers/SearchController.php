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
        $type = $request->input('type', 'movies');

        if ($type === 'movies') {
            $results = Movie::query()
                ->select('id', 'title', 'poster')
                ->where('title', 'LIKE', "%{$request->query('search')}%")
                ->orderBy('title')
                ->paginate(10);
        } elseif ($type === 'celebs') {
            $results = Celeb::query()
                ->select('id', 'name', 'photo')
                ->where('name', 'LIKE', "%{$request->query('search')}%")
                ->orderBy('name')
                ->paginate(10);
        }

        return view('search', [
            'search' => $search,
            'type' => $type,
            'results' => $results->appends(['type' => $type, 'search' => $search]),
        ]);
    }
}
