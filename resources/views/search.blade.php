@extends('layouts.app')

@section('title', 'MovieDeck | Search')

@section('content')
    <div class="flex flex-col my-20 w-full items-center">
        <form method="GET" action="{{ route('search') }}" class="w-5/6">
            @csrf
            <label for="search" class="title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500">Search</label>
            <input id="search" name="search" type="text" value="{{ old('search', $keyword) }}" class="flex w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Find Movies and Celebs">
        </form>
    </div>
    <div class="container px-6 mx-auto md:flex">
        <div class="text-gray-600 body-font">
                <div class="flex flex-col pr-4 py-2 tracking-wide">
                    <h1 class="font-medium text-gray-600 text-2xl">Titles</h1>
                    <h1 class="text-gray-700 text-l whitespace-nowrap">{{ $movies->total() }} Results</h1>
                </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('movies.show', $movie->id) }}">
                                <img class="object-cover w-60 h-full" src="{{ $movie->poster }}" alt="movie_poster">
                            </a>
                            <div class="flex justify-between mt-1">
                                <h3>{{ $movie->title }}</h3>
                                @if(auth()->check())
                                    <form method="post" action="{{ route('watchlist.store', auth()->user()->id) }}">
                                        @csrf
                                        <button value="{{$movie->id}}" name="movie_id" class="flex text-gray-600 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform hover:text-gray-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center py-20">
                {{ $movies->links() }}
            </div>
            <div class="flex flex-col pr-4 py-2 tracking-wide">
                <h1 class="font-medium text-gray-600 text-2xl">Names</h1>
                <h1 class="text-gray-700 text-l whitespace-nowrap">{{ $celebs->total() }} Results</h1>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($celebs as $celeb)
                        <div>
                            <a href="{{ route('celebs.show', $celeb->id) }}">
                                <img class="object-cover w-60 h-full" src="{{ $celeb->photo }}" alt="movie_poster">
                            </a>
                            <h3 class="flex justify-center mt-1">{{ $celeb->name }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center py-20">
                {{ $celebs->links() }}
            </div>
        </div>
    </div>
@endsection
