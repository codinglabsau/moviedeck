@extends('layouts/app')

@section('content')
    <div class="container px-6 py-3 mx-auto">
        <section class="text-gray-600 body-font">
            {{--     Movie Summary Section       --}}
            <div class="container mx-auto flex px-5 py-32 md:flex-row flex-col items-center">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <div class="flex justify-center mb-12">
                        <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                            <span class="mx-2 whitespace-nowrap">{{ $movie->year }}</span>
                        </div>
                        <div class="flex items-center ml-5 px-4 py-2 font-medium text-white tracking-wide capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#fff">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="whitespace-nowrap font-normal"> 4.8 / 10 </span>
                        </div>
                    </div>
                    <h1 class="title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-900"> {{ $movie->title }}  </h1>
                    <div class="flex justify-center mb-12">
                        <div class="flex items-center py-2 font-medium tracking-wide">
                            <span class="mx-2 whitespace-nowrap">
                                {{ $duration[0] }} hrs
                                {{ $duration[1] }} min
                            </span>
                            <span class="whitespace-nowrap font-normal">
                                <span class="mx-4 whitespace-nowrap">|</span>
                                @foreach($genres as $genre)
                                    @foreach($genre->genres as $tags)
                                        @if ($tags->pivot->movie_id == $movie->id)
                                            {{ ($tags->name) }}@if (!$loop->last),@endif
                                        @endif
                                    @endforeach
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
                            <a href="{{ $movie->trailer }}"><span class="mx-2 whitespace-nowrap">Play Trailer</span></a>
                        </button>
                        <button class="flex items-center ml-5 px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-blue-500">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <a href="#"><span class="mx-2 whitespace-nowrap text-gray-700 font-normal">Add to Watchlist</span></a>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="w-full px-6 py-3 mx-auto bg-white">
        <section class="text-gray-600 body-font">
            <div class="container w-full mx-auto flex bg-white shadow overflow-hidden sm:rounded-lg -mt-16">
                <div>
                    <div class="pl-96 pr-12 py-8 bg-gray-300">
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-6xl font-bold text-gray-600"> 4.8 <span class="font-normal text-3xl">/ 10</span></h1>
                                <h4> 1,923 reviews </h4>
                            </div>
                            <div class="my-6">
                                <button class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md">
                                    Read All Reviews
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="flex px-4 py-5">
                        <img class="h-80 mx-12 -mt-24 mb-12" src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                        <p class="pl-5 pr-12 py-12">{{ $movie->synopsis }}</p>
                    </div>
                </div>
            </div>
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-center">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="font-medium text-gray-500 text-4xl py-6">Main Casts</h1>
                    @foreach($castings as $casting)
                        @foreach($casting->celebs as $cast)
                            @if ($cast->pivot->movie_id == $movie->id)
                                <div class="flex justify-between">
                                    <img class="h-20 border " src="{{ $cast->photo }}" alt="{{ $cast->name }}">
                                    <p> {{ $cast->name }} </p>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="font-medium text-gray-500 text-4xl">Recent Reviews</h1>
                </div>
            </div>
        </section>
    </div>
@endsection
