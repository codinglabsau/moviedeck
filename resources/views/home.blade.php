@extends('layouts.app')

@section('content')
    <div class="w-full bg-bottom bg-cover shadow-inner shadow-lg" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(27, 28, 32, 1)), url('{{ $random->banner }}'); height: 90vh;">
        <div class="container px-6 py-3 mx-auto">
            <section class="text-gray-600 body-font">
                {{--     Movie Summary Section       --}}
                <div class="container mx-auto flex px-5 py-32 mt-64 md:flex-row flex-col items-center align-baseline">
                    <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        <div class="flex justify-center mb-12">
                            <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-200">
                                <span class="text-gray-200 mx-2 whitespace-nowrap">{{ $random->year }}</span>
                            </div>
                            <div class="flex items-center ml-5 px-4 py-2 font-medium text-white tracking-wide capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#fff">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span class="whitespace-nowrap font-normal"> {{ $random->average_rating }} / 10 </span>
                            </div>
                        </div>
                        <a href="{{ route('movies.show', $random) }}"><h1 class="title-font sm:text-6xl text-5xl mb-4 font-medium text-white"> {{ $random->title }}  </h1></a>
                        <div class="flex justify-center mb-12">
                            <div class="flex items-center py-2 font-medium tracking-wide">
                                <span class="text-gray-300 mx-2 whitespace-nowrap"> {{ $random->duration }} </span>
                                <span class="whitespace-nowrap font-normal">
                                    <span class="text-gray-300 mx-4 whitespace-nowrap">|</span>
                                    @foreach($random->genres as $genre)
                                            <span class="text-gray-300">{{ ($genre->name) }}@if (!$loop->last),@endif</span>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <a href="{{ $random->trailer }}"><span class="mx-2 whitespace-nowrap">Play Trailer</span></a>
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
    <div class="container mx-auto px-6 py-3 md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="font-medium text-gray-700 whitespace-nowrap capitalize md:text-2xl">Featured Movies</span>
                </div>
                <div class="flex px-4 py-2 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                    <a href="{{ route('movies.index') }}" class="mx-2 whitespace-nowrap">All Movies</a>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-20 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ route('movies.show', $movie) }}">
                                <img class="object-cover w-60 h-full" src="{{ $movie->poster }}" alt="{{ $movie->poster }}">
                            </a>
                            <div class="flex justify-between">
                                <h3>{{ $movie->title }}</h3>
                                <h3>{{ $movie->average_rating }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container px-6 py-3 mx-auto mb-24 md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <span class="font-medium text-gray-700 whitespace-nowrap capitalize md:text-2xl">Explore Celebs</span>
                </div>
                <div class="flex px-4 py-2 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                    <a href="{{ route('celebs.index') }}" class="mx-2 whitespace-nowrap">All Celebs</a>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-20 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($celebs as $celeb)
                        <div>
                            <a href="{{ route('celebs.show', $celeb) }}">
                                <img class="object-cover w-60 h-full" src="{{ $celeb->photo }}" alt="{{ $celeb->photo }}">
                                <h3>{{ $celeb->name }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="w-full bg-gray-300 shadow-inner shadow-lg">
        <div class="container px-6 mt-24 pb-24 mx-auto">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Latest Reviews</span>
                </div>
                <div class="flex px-4 py-2 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                    <a href="{{ route('reviews.index') }}" class="mx-2 whitespace-nowrap">All Reviews</a>
                </div>
            </div>
            <div class="grid gap-12 mt-0 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-stretch">
                @foreach($reviews as $review)
                    <div class="bg-white rounded rounded-sm p-4">
                        <div class="flex flex-col my-4 mx-auto items-center">
                            <a href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                <img class="flex h-60 border rounded-sm" src="{{ $review->movie->poster }}" alt="{{ $review->movie->title }}">
                                <h1 class="text-sm font-semibold py-4">{{ $review->movie->title }}</h1>
                            </a>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                <h1 class="font-bold text-lg tracking-wide">
                                    <svg class="w-5 h-5 inline-flex align-top" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span>{{ $review->rating }}</span>
                                    <span class="font-normal text-sm">/ 10</span> </h1>
                                <h2 class="font-medium pt-2 text-md"> {{ $review->title }} </h2>
                            </a>
                            <span class="font-bold text-sm text-blue-500 mr-4"> {{ $review->user->name }} </span><br/>
                            <span class="font-normal text-sm"> {{ $review->created_at->diffForHumans() }} </span>
                            <p class="mt-6">
                                {{ $review->excerpt }}
                                @if(strlen($review->content) > 200)
                                    <button><a class="flex flex-col text-sm text-blue-400 hover:text-blue-500" href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">Read More</a></button>
                                @endif
                            </p>
                        </div>
                        @if (auth()->check())
                            <div class="flex flex-row">
                                @if(request()->user()->id === $review->user->id)
                                    <div class="items-center align-bottom py-2">
                                        <a href="{{ route('reviews.edit', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                            <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                                <span class="mx-2 whitespace-nowrap">Edit</span>
                                            </button>
                                        </a>
                                    </div>
                                @endif
                                @if (request()->user()->id === $review->user->id || request()->user()->is_admin)
                                    <div class="items-center align-middle px-2 py-2">
                                        <form method="POST" action="{{ route('reviews.destroy', ['movie' => $review->movie->id, 'review' => $review]) }}">
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
                @endforeach
            </div>
        </div>
    </div>
    @guest
        <div class="w-full bg-fixed bg-bottom bg-cover shadow-inner shadow-lg" style="background-image: linear-gradient(rgba(27, 28, 32, 0.8), rgba(0, 0, 0, 1)), url('https://i.redd.it/4fxxbm4opjd31.jpg')">
            <div class="container px-6 mx-auto">
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto flex px-5 py-32 md:flex-row flex-col items-center align-baseline">
                        <div class="w-full flex flex-col items-center text-center">
                            <div class="flex justify-center mb-12">
                                <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-200">
                                    <span class="text-gray-200 mx-2 whitespace-nowrap uppercase text-sm font-bold"> Lifetime access </a> </span>
                                </div>
                            </div>
                            <h1 class="title-font mx-40 sm:text-6xl text-5xl mb-4 font-medium text-white"> Unlimited access to your favourite movies, reviews and more.  </h1>
                            <div class="flex justify-center mb-6">
                                <div class="flex items-center py-2 font-normal tracking-wide">
                                    <span class="text-gray-300 mx-2 whitespace-nowrap"> Join our membership for free! </span>
                                </div>
                            </div>
                            <div class="flex justify-center">
                                <button class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <a href="{{ route('register') }}"><span class="mx-2 whitespace-nowrap">Get Started</span></a>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endguest
@endsection
