@extends('layouts.app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container px-6 py-3 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-800 text-4xl whitespace-nowrap">Movies</h1>
                </div>
                @if (auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('movies.create') }}">
                        <button class="flex p-4 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                            <span class="whitespace-nowrap">Add Movie</span>
                        </button>
                    </a>
                @endif
            </div>
            @if(session()->has('message'))
                <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 rounded rounded-md p-6 mb-12">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="flex items-baseline justify-center">
                <div class="grid gap-16 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <div class="flex flex-col">
                                <a href="{{ route('movies.show', $movie) }}">
                                    <img class="object-cover w-60 h-96" src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                                </a>
                                <div class="flex justify-between my-6">
                                    <h3>{{ $movie->title }}</h3>
                                    <h3 class="flex flex-row">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 align-middle mr-1 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ $movie->average_rating }}
                                    </h3>
                                </div>
                            </div>
                            <div class="flex flex-row">
                                @if (auth()->check() && auth()->user()->is_admin)
                                    <div class="items-center align-bottom py-2">
                                        <a href="{{ route('movies.edit', $movie) }}">
                                            <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                                <span class="mx-2 whitespace-nowrap">Edit</span>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="items-center align-middle px-2 py-2">
                                        <form method="POST" action="{{ route('movies.destroy', $movie) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="bg-gray-300 rounded rounded-sm text-gray-500 hover:text-gray-600" type="submit">
                                                <span class="mx-2 whitespace-nowrap">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
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
