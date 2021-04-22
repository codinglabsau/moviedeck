@extends('layouts.main')

@section('content')
    <div class="w-full px-6 py-3 mx-auto">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="font-medium text-gray-500 text-4xl py-16">Titles</h1>
                    @foreach ($celeb->movies as $movie)
                        <div class="flex w-full justify-between">
                            <div class="flex">
                                <a href="{{ route('movies.show', $movie) }}"><img class="h-12 border rounded-sm my-4" src="{{ $movie->poster }}" alt="{{ $movie->title }}"></a>
                                <span class="p-6 font-medium"> <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a> </span>
                            </div>
                            <div class="flex">
                                <span class="p-6 font-light">
                                    as {{ $movie->pivot->character_name }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col items-end mb-16 md:mb-0">
                    <div class="flex-col py-6">
                        <img class="w-80 rounded-md" src="{{ $celeb->photo }}" alt="actor photo">
                        <h2 class="font-medium text-gray-800 text-2xl py-4 text-center">{{ $celeb->name }}</h2>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
