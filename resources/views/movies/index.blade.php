@extends('layouts.main')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container px-6 py-3 mx-auto md:flex">
        <section class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex items-center ml-5 pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-500 text-4xl whitespace-nowrap">Popular Movies</h1>
                </div>
                @if (auth()->check() && auth()->user()->is_admin == 1)
                    <div class="flex items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                        <a href="{{ route('movies.create') }}" class="mx-2 px-4 whitespace-nowrap">Add Movie</a>
                    </div>
                @endif
            </div>

            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="grid grid-flow-row sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-28">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('movies.show', $movie) }}">
                                <img class="w-48" src="{{ $movie->poster }}" alt="{{ $movie->poster }}">
                            </a>
                            <div class="flex justify-between">
                                <h3><a href="{{ route('movies.show', $movie) }}"> {{ $movie->title }} </a></h3>
                                <h3> 4.8 </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
