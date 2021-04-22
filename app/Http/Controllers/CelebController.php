<?php

namespace App\Http\Controllers;

use App\Models\Celeb;
use Illuminate\Http\Request;
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

    public function store(CelebRequest $request, celeb $celeb)
    {
        Celeb::create($request->validated());
        return redirect("celebs/$celeb->id");
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

    public function update(CelebRequest $request, Celeb $celeb)
    {
        //
    }

    public function destroy(Celeb $celeb)
    {
        //
    }
}
