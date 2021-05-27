<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Celeb;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        $keyword = $request->input('search');
        $switch = $request->input('switch');

        if($switch === 'movies') {
            $results = Movie::query()
                ->select('id', 'title', 'poster')
                ->when($keyword, function ($q) use ($keyword) {
                    $q->where('title', 'LIKE', "%{$keyword}%");
                })
                ->orderBy('title')
                ->paginate(10);
        } else {
            $results = Celeb::query()
                ->select('id', 'name', 'photo')
                ->when($keyword, function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orderBy('name')
                ->paginate(10);
        }

        return view('search', [
            'keyword' => $keyword,
            'switch' => $switch,
            'results'  => $results,
        ]);
    }
}
