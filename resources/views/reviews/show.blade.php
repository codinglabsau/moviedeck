@extends('layouts.app')

@section('title', 'MovieDeck | Give reviews to your fave movies!')

@section('content')
    <div class="w-full px-6 py-3 mx-auto">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
                <div class="flex flex-col w-3/4 md:items-start md:text-left mr-20 mb-16 md:mb-0 items-center text-center bg-white p-12">
                    @if(session('status'))
                        <div class="w-full text-indigo-500 bg-indigo-100 border border-2 border-indigo-400 rounded rounded-md p-6 mb-12">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1 class="font-medium text-gray-500 text-4xl">A review of
                        <span class="text-blue-500">
                            <a href="{{ route('movies.show', $review->movie) }}">{{ $review->movie->title }}</a>
                        </span>
                    </h1>
                    <span class="font-bold text-sm text-blue-500 mt-2"> {{ $review->user->name }} </span>
                    <span class="font-normal text-sm"> {{ $review->created_at->diffForHumans() }} </span>
                    <div class="flex w-full justify-between my-10">
                        <div class="flex flex-col">
                            <h1 class="font-medium pt-2 text-2xl"> {{ $review->title }} </h1>
                            <p class="py-2"> {{ $review->content }} </p>
                        </div>
                        <div class="flex flex-col align-middle ml-8 p-6">
                            <div class="flex flex-col font-light">
                                Rating:
                                <h1 class="font-bold text-lg tracking-wide">
                                    <span class="text-2xl">{{ $review->rating }}</span>
                                    <span class="font-normal text-sm">/ 10</span>
                                </h1>
                            </div>
                            <div class="flex flex-row">
                                @for($i = 0; $i <= 10; $i++)
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @if (auth()->check())
                        <div class="flex flex-row">
                            @if(auth()->id() === $review->user->id)
                                <div class="items-center align-bottom py-2">
                                    <a href="{{ route('reviews.edit', $review) }}">
                                        <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                            <span class="mx-2 whitespace-nowrap">Edit</span>
                                        </button>
                                    </a>
                                </div>
                            @endif
                            @if (auth()->id() === $review->user->id || auth()->user()->is_admin)
                                <div class="items-center align-middle px-2 py-2">
                                    <form method="POST" action="{{ route('reviews.delete', $review) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-gray-300 rounded rounded-sm text-gray-500 hover:text-gray-600" type="submit">
                                            <span class="mx-2 whitespace-nowrap">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="flex flex-col w-1/4 items-end mb-16 md:mb-0">
                    <a href="{{ route('movies.show', $review->movie) }}">
                        <img class="flex w-full border rounded-sm mb-4 align-middle items-center" src="{{ $review->movie->poster }}" alt="{{ $review->movie->title }}">
                    </a>
                    <div class="flex w-full justify-between">
                        <button class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <a href="{{ $review->movie->trailer }}"><span class="mx-2 whitespace-nowrap text-sm">Play Trailer</span></a>
                        </button>
                        <button class="flex items-center px-2 py-2 font-medium tracking-wide capitalize rounded-md bg-gray-800 hover:bg-gray-600">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f8f8f8">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <a href="#"><span class="text-gray-300 mx-2 whitespace-nowrap font-normal text-sm">Add to Watchlist</span></a>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
