@extends('layouts.app')

@section('content')

    <div class="container flex px-6 py-10 mx-auto space-y-6 md:h-128 md:py-16 md:items-center md:space-x-6">
        <div class="w-full md:w-1/2">
            <div class="max-w-lg">
                <h1 class="text-2xl flex items-start font-medium tracking-wide text-gray-800 md:text-4xl">Titles</h1>
                <div>
                    @foreach ($titles as $title)
                        @foreach ($title->movies as $info)
                            <div class="flex items-center justify-between py-2 space-x-6 text-gray-800">
                                <img class="object-fit w-16 h-20 rounded-md" src="{{$info->poster}}" alt="movie_poster">
                                <span class="flex ">{{$info->pivot->character_name}}</span>
                                <span class="italic">{{$info->title}}</span>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center w-full md:w-1/2">
            <img class="w-3/4 h-3/4 rounded-md" src="{{$celeb->photo}}" alt="actor photo">
            <p class="font-bold">{{$celeb->name}}</p>
        </div>
    </div>

@endsection
