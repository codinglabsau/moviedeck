@extends('layouts.app')

@section('title', 'MovieDeck | Search')

@section('content')
    <div class="flex flex-col my-20 w-full items-center">
        <form method="GET" action="{{ route('search') }}" class="w-5/6">
            @csrf
            <label for="search" class="title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500">Search</label>
            <div class="flex flex-row">
                <select name="switch" id="switch" class="flex px-1 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring">
                    <option value="movies" @if($switch === 'movies') selected @endif>Movies</option>
                    <option value="celebs" @if($switch === 'celebs') selected @endif>Celebs</option>
                </select>
                <input id="search" name="search" type="text" value="{{ old('search', $keyword) }}" class="flex w-full ml-1 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Find Movies or Celebs">
            </div>
        </form>
    </div>
    <div class="container px-6 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <h1 class="font-medium pb-6 tracking-wide text-gray-600 text-2xl">{{ $results->total() }} Results</h1>
            @if($switch === 'movies')
                <div class="flex items-baseline justify-center">
                    <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        @foreach($results as $result)
                            <div>
                                <a href="{{ route('movies.show', $result->id) }}">
                                    <img class="object-cover w-60 h-full" src="{{ $result->poster }}" alt="poster">
                                </a>
                                <div class="flex justify-between mt-1">
                                    <h3>{{ $result->title }}</h3>
                                    @if(auth()->check())
                                        <form method="post" action="{{ route('watchlist.store', auth()->user()->id) }}">
                                            @csrf
                                            <button value="{{$result->id}}" name="movie_id" class="flex text-gray-600 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform hover:text-gray-800 focus:outline-none">
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
                    {{ $results->links() }}
                </div>
            @else
                <div class="flex items-baseline justify-center">
                    <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        @foreach($results as $result)
                            <div>
                                <a href="{{ route('celebs.show', $result->id) }}">
                                    <img class="object-cover w-60 h-full" src="{{ $result->photo }}" alt="celeb_photo">
                                </a>
                                <h3 class="flex justify-center mt-1">{{ $result->name }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-center py-20">
                    {{ $results->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
