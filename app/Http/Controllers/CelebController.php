<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use Illuminate\Http\Request;

class CelebController extends Controller
{
    public function index()
    {
        $celebs = Celeb::orderBy('name')
            ->paginate(20);

        return view('celebs/index', [
            'celebs' => $celebs
        ]);
    }

    public function create()
    {
        return view('celebs/create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Celeb $celeb)
    {
        $celeb->with('movies')->get();

        return view('celebs/show', [
            'celeb' => $celeb
        ]);
    }

    public function edit(Celeb $celeb)
    {
        return view('celebs/edit')->with('celeb', $celeb);
    }

    public function update(Request $request, Celeb $celeb)
    {
        //
    }

    public function destroy(Celeb $celeb)
    {
        //
    }
}
