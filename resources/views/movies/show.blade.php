@extends('layouts.app')

@section('content')
    <div class="w-full bg-fixed bg-bottom bg-cover" style="background-image: linear-gradient(rgba(248, 248, 248, 0.2), rgba(28, 28, 28, 0.9)), url('{{ $movie->banner }}')">
        <div class="container px-6 py-3 mx-auto">
            <section class="text-gray-600 body-font">
                {{--     Movie Summary Section       --}}
                <div class="container mx-auto flex px-5 py-32 md:flex-row flex-col items-center">
                    <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        @if(session()->has('message'))
                            <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 rounded rounded-md p-6 mb-12">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="flex justify-center mb-12">
                            <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-200">
                                <span class="text-gray-200 mx-2 whitespace-nowrap">{{ $movie->year }}</span>
                            </div>
                            <div class="flex items-center ml-5 px-4 py-2 font-medium text-white tracking-wide capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#fff">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span class="whitespace-nowrap font-normal"> 4.8 / 10 </span>
                            </div>
                        </div>
                        <h1 class="title-font sm:text-6xl text-5xl mb-4 font-medium text-white"> {{ $movie->title }}  </h1>
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
                                    <form method="POST" action="{{ route('movies.delete', $movie) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-gray-300 rounded rounded-sm text-gray-500 hover:text-gray-600" type="submit">
                                            <span class="mx-2 whitespace-nowrap">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-center mb-12">
                            <div class="flex items-center py-2 font-medium tracking-wide">
                                <span class="text-gray-300 mx-2 whitespace-nowrap"> {{ $movie->duration }} </span>
                                <span class="whitespace-nowrap font-normal">
                                    <span class="text-gray-300 mx-4 whitespace-nowrap">|</span>
                                </span>
                                @foreach($movie->genres as $genre)
                                    <span class="text-gray-300"> {{ $genre->name }}@if (!$loop->last),@endif&nbsp;</span>
                                @endforeach
                                @if (auth()->check() && auth()->user()->is_admin)
                                    <div class="items-center align-bottom px-2 py-2">
                                        <a href="{{ route('movies.edit', $movie) . "#genres" }}">
                                            <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                                <span class="mx-2 whitespace-nowrap">Manage Genres</span>
                                            </button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <a href="{{ $movie->trailer }}"><span class="mx-2 whitespace-nowrap">Play Trailer</span></a>
                            </button>
                            <button class="flex items-center ml-5 px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-transparent rounded-md hover:bg-gray-800 focus:outline-none focus:bg-blue-500">
                                <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f8f8f8">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                <a href="#"><span class="text-gray-300 mx-2 whitespace-nowrap font-normal">Add to Watchlist</span></a>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="w-full px-6 py-3 mx-auto bg-white">
        <section class="text-gray-600 body-font">
            <div class="container w-full mx-auto flex bg-white shadow overflow-hidden sm:rounded-lg -mt-16">
                <div>
                    <div class="pl-96 pr-12 py-8 bg-gray-300">
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-6xl font-bold text-gray-600">
                                    4.8 <span class="font-normal text-3xl">/ 10</span></h1>
                                <h4>
                                    <svg class="w-5 h-5 inline-flex align-top" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    {{ $movie->reviews->count() }} reviews
                                </h4>
                            </div>
                            <div class="my-6">
                                <a href="{{ route('reviews.create', ['movie' => $movie]) }}">
                                    <button class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md">
                                        Add Review
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex px-4 py-5">
                        <img class="w-60 mx-12 -mt-24 mb-12" src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                        <p class="pl-5 pr-12 py-12">{{ $movie->synopsis }}</p>
                    </div>
                </div>
            </div>
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <div class="flex py-16">
                        <div class="flex">
                            <h1 class="font-medium text-gray-500 text-4xl">Main Casts</h1>
                        </div>
                        <div class="flex mx-6">
                            @if (auth()->check() && auth()->user()->is_admin)
                                <div class="items-center align-bottom py-2">
                                    <a href="{{ route('movies.edit.cast', $movie) }}">
                                        <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                            <span class="mx-2 whitespace-nowrap">Manage Casts</span>
                                        </button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @forelse($movie->celebs as $celeb)
                        <div class="flex w-full justify-between">
                            <div class="flex">
                                <a href="{{ route('celebs.show', $celeb) }}"><img class="h-12 border rounded-sm my-4" src="{{ $celeb->photo }}" alt="{{ $celeb->name }}"></a>
                                <span class="p-6 font-medium"> <a href="{{ route('celebs.show', $celeb) }}">{{ $celeb->name }}</a> </span>
                            </div>
                            <div class="flex">
                                <span class="p-6 font-light">
                                    as {{ $celeb->pivot->character_name }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div>
                            <p>
                                No casts added yet.
                                <a href="{{ route('movies.edit.cast', $movie) }}" class="text-blue-500 font-semibold text-sm">Add a Cast</a>
                            </p>
                        </div>
                    @endforelse
                </div>
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="font-medium text-gray-500 text-4xl py-16">Recent Reviews</h1>
                    @forelse($reviews as $review)
                        <div class="flex-col py-6">
                            <a href="{{ route('reviews.show', ['movie' => $movie, 'review' => $review]) }}">
                                <h1 class="font-bold text-lg tracking-wide"> <svg class="w-5 h-5 inline-flex align-top" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg> {{ $review->rating }} <span class="font-normal text-sm">/ 10</span> </h1>
                                <h2 class="font-medium pt-2 text-md"> {{ $review->title }} </h2>
                            </a>
                            <span class="font-bold text-sm text-blue-500 mr-4"> {{ $review->user->name }} </span>
                            <span class="font-normal text-sm"> {{ $review->created_at->diffForHumans() }} </span>
                            <p class="py-2"> {{ $review->excerpt }}
                                @if(strlen($review->content) > 200)
                                    <button><a class="flex flex-col text-sm text-blue-400 hover:text-blue-500" href="{{ route('reviews.show', ['movie' => $movie, 'review' => $review]) }}">Read More</a></button>
                                @endif
                            </p>
                        </div>
                        @empty
                        <div>
                            <p>
                                No reviews found.
                                <a href="{{ route('reviews.create', $movie) }}" class="text-blue-500 font-semibold text-sm">Add a Review</a>
                            </p>
                        </div>
                    @endforelse
                    <div class="py-6">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
