<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use App\Models\Movie;
use App\Http\Requests\CelebRequest;

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

    public function store(CelebRequest $request)
    {
        $celeb = Celeb::create($request->validated());

        return redirect("celebs/$celeb->id")
            ->with('message', 'Celeb Successfully Added');
    }

    public function show(Celeb $celeb)
    {
        $titles = $celeb->movies()
                        ->paginate(4)
                        ->onEachside(1);

        return view('celebs/show', [
            'celeb' => $celeb,
            'titles' => $titles
        ]);
    }

    public function edit(Celeb $celeb)
    {
        return view('celebs/edit', [
            'celeb' => $celeb
        ]);
    }

    public function update(CelebRequest $request, Celeb $celeb)
    {
        $celeb->update($request->validated());

        return redirect("celebs/$celeb->id")
            ->with('message', 'Celeb Successfully Updated');
    }

    public function destroy(Celeb $celeb)
    {
        $celeb->delete();

        return redirect('celebs')
            ->with('message', 'Celeb Successfully Deleted');
    }
}
