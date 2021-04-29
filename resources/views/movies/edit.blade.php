@extends('layouts.app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
        <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
            <h1 class="font-medium text-gray-500 text-4xl mb-6">Add a Movie
            </h1>
            @if ($errors->any())
                <div class="text-red-500 bg-red-100 border border-2 border-red-400 rounded rounded-md p-6 m-2 w-full">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="flex w-full justify-between">
                <form method="POST" action="{{ route('movies.update', $movie) }}" class="mx-auto w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="title"> Title: </label>
                                <input type="text" name="title" value="{{ $movie->title }}" class="w-3/4 mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                            <div class="w-1/2">
                                <label for="year"> Year: </label>
                                <input type="text" name="year" value="{{ $movie->year }}" class="w-auto mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                <span class="text-sm text-gray-400"> 4-digit format </span>
                            </div>
                        </div>

                        <label for="synopsis"> Synopsis: </label>
                        <textarea type="text" name="synopsis" class="my-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">{{ $movie->synopsis }}</textarea>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="poster"> Poster: </label>
                                <input type="text" name="poster" value="{{ $movie->poster }}" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                <span class="text-sm text-gray-400"> Poster Photo URL </span>
                            </div>
                            <div class="w-1/2">
                                <label for="banner"> Banner: </label>
                                <input type="text" name="banner" value="{{ $movie->banner }}" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                <span class="text-sm text-gray-400"> Banner Photo URL </span>
                            </div>
                        </div>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="trailer"> Trailer: </label>
                                <input type="text" name="trailer" value="{{ $movie->trailer }}" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                <span class="text-sm text-gray-400">YouTube, Vimeo, etc. </span>
                            </div>
                            <div class="w-1/2">
                                <label for="duration"> Duration: </label>
                                <input type="text" name="duration" value="{{ $movie->getRawDuration() }}" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                <span class="text-sm text-gray-400">Minutes</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row mt-6 align-middle items-center">
                            <button type="submit" class="flex w-max px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Add</button>
                            <a class="text-gray-400 hover:text-gray-600 px-4 py-2" href="{{ route('movies.show', $movie) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-1/4 flex flex-col items-end mb-16 md:mb-0">
            <div class="flex-col pb-6">
                <a href="{{ route('movies.show', $movie) }}" target="_blank">
                    <img class="flex w-80 border rounded-sm mb-4 align-middle justify-end" src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                </a>
            </div>
            <div class="flex justify-center">
                <button class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <a href="{{ $movie->trailer }}" target="_blank"><span class="mx-2 whitespace-nowrap text-sm">Play Trailer</span></a>
                </button>
                <button class="flex items-center ml-5 px-2 py-2 font-medium tracking-wide capitalize rounded-md bg-gray-800 hover:bg-gray-600">
                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f8f8f8">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <a href="#"><span class="text-gray-300 mx-2 whitespace-nowrap font-normal text-sm">Add to Watchlist</span></a>
                </button>
            </div>
        </div>
    </div>
@endsection
