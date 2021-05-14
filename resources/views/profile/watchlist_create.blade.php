@extends('layouts.app')

@section('title', 'MovieDeck | Add a Watchlist Item')

@section('content')
    <div class="flex flex-col my-20 w-full items-center">
        <h1 class="flex justify-center w-full title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500">Search for a movie to add to your watchlist</h1>
        <form method="POST" action="{{ route('profile.watchlistCreate', $user->id) }}" class="w-5/6">
            @csrf
            <input id="search" name="search" type="text" value="{{ old('search', $validated) }}" class="@error('search') is-invalid @enderror flex w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Search">
            @error('search')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
            @enderror
        </form>
    </div>
    <div class="container px-6 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12">
                <div class="flex flex-col pr-4 py-2 tracking-wide">
                    <h1 class="font-medium text-gray-400 text-4xl whitespace-nowrap">Movies with <i>{{$keyword}}</i> in the title</h1>
                    <p class="mt-3 text-gray-600">{{ count($movies) }} Results</p>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('profile.watchlist.store', ['user'=>$user->id, 'movie'=>$movie->id]) }}">
                                <img class="object-cover w-60 h-full" src="{{ $movie->poster }}" alt="movie_poster">
                                <h3>{{ $movie->title}}</h3>
                            </a>
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
