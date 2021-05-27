@extends('layouts.app')

@section('title', 'MovieDeck | Give reviews to your fave movies!')

@section('content')
    <div class="w-full px-6 py-3 mx-auto">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
                <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
                    <h1 class="font-medium text-gray-500 text-4xl mb-6">Update your review of
                        <span class="text-blue-500">
                            <a href="{{ route('movies.show', $movie) }}" target="_blank">{{ $movie->title }}</a>
                        </span>
                    </h1>
                    @if ($errors->any())
                        <div class="text-red-500 bg-red-100 border border-2 border-red-400 rounded rounded-md p-6 m-2 w-full">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="flex w-full justify-between">
                        <form method="POST" action="{{ route('reviews.update', ['movie' => $movie, 'review' => $review]) }}" class="mx-auto w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $review->user_id }}">
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <div class="flex flex-row">
                                <div class="flex flex-col pb-6">
                                    <label for="title" class="text-md font-medium py-2">Review Title:</label>
                                        <textarea name="title" cols="60" rows="5" class="outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-4 text-md font-light">{{ $review->title }}</textarea>
                                </div>
                                <div class="flex flex-col font-light p-10">
                                    Rating:
                                    <h1 class="font-bold text-lg tracking-wide py-4">
                                        <input name="rating" title="rating" value="{{ $review->rating }}" class="outline-none w-14 border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-center text-md font-light">
                                        <span class="font-normal text-sm">/ 10</span>
                                    </h1>
                                    <div class="flex flex-row">
                                        @for($i = 0; $i <= 10; $i++)
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="content" class="text-md font-medium py-2">Review:</label>
                                    <textarea name="content" cols="60" rows="10" class="outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-4 text-md font-light">{{  $review->content }}</textarea>
                                <div class="flex flex-row mt-6 align-middle items-center">
                                    <button type="submit" class="flex w-max px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Update</button>
                                    <a class="text-gray-400 hover:text-gray-600 px-4" href="{{ route('reviews.show', ['movie' => $movie, 'review' => $review]) }}">Cancel</a>
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
                    <div x-data="{ open: false }" class="flex justify-center">
                        <button @click="open = true" class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="mx-2 whitespace-nowrap">Play Trailer</span>
                        </button>
                        @if(auth()->check())
                            <form method="post" action="{{ route('watchlist.store', ['user'=>auth()->user()->id, 'movie'=>$movie->id]) }}">
                                @csrf
                                <button value="{{$movie->id}}" name="movie_id" class="flex items-center ml-5 px-2 py-2 font-medium tracking-wide capitalize rounded-md bg-gray-800 hover:bg-gray-600">
                                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f8f8f8">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    <span class="text-gray-300 mx-2 whitespace-nowrap font-normal">Add to Watchlist</span>
                                </button>
                            </form>
                        @endif
                        <div class="fixed top-0 left-0 flex items-center justify-center w-full h-full z-50 transition transition-all ease-in-out duration-1000" style="background-color: rgba(0,0,0,.8);" x-show="open">
                            <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl w-auto" @click.away="open = false">
                                <iframe src="{{ $movie->trailer }}" width="1280" height="720" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
