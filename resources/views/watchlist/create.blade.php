@extends('layouts.app')

@section('title', 'MovieDeck | Add a Watchlist Item')

@section('content')
    <div class="flex flex-col my-24 w-full items-center">
        <h1 class="flex justify-center w-full title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500 mb-12">Search for a movie to add to your watchlist</h1>
        <form method="GET" action="{{ route('watchlist.create', $user->id) }}" class="w-5/6">
            @csrf
            <input id="search" name="search" type="text" value="{{ old('search', $keyword) }}" class="flex w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Search">
        </form>
    </div>
    <div class="container px-6 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12">
                <div class="flex flex-col pr-4 py-2 tracking-wide">
                    <h1 class="font-medium text-gray-500 text-xl whitespace-nowrap">{{ $movies->total() }} Results</h1>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-x-12 gap-y-24 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('movies.show', $movie->id) }}">
                                <img class="object-cover w-60 h-full" src="{{ $movie->poster }}" alt="movie_poster">
                            </a>
                            <div class="flex justify-between mt-1">
                                <h3>{{ $movie->title}}</h3>
                                <form method="post" action="{{ route('watchlist.store', ['user'=>$user->id, 'movie'=>$movie->id]) }}">
                                    @csrf
                                    <button value="{{$movie->id}}" name="movie_id" class="h-8 flex text-gray-600 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                                        <span class="mx-2 whitespace-nowrap text-sm">Add</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center mt-32 mb-24">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
@endsection
