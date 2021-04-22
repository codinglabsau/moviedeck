@extends('layouts.main')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container px-6 py-3 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-500 text-4xl whitespace-nowrap">Popular Movies</h1>
                </div>
                @if (auth()->check() && auth()->user()->is_admin)
                    <div class="flex items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                        <a href="{{ route('movies.create') }}" class="mx-2 px-4 whitespace-nowrap">Add Movie</a>
                    </div>
                @endif
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('movies.show', $movie) }}">
                                <img class="object-cover w-60 h-full" src="{{ $movie->poster }}" alt="{{ $movie->poster }}">
                            </a>
                            <div class="flex justify-between">
                                <h3>{{ $movie->title }}</h3>
                                <h3> 4.8 </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center py-20">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
@endsection
