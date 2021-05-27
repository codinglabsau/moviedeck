@extends('layouts.app')

@section('content')
    <div class="bg-gray-700 px-12 py-3 w-full bg-fixed bg-bottom bg-cover" style="background-image: linear-gradient(rgba(248, 248, 248, 0.2), rgba(28, 28, 28, 0.9)), url('{{ $movies->first()->banner }}')">
        @if(session()->has('message'))
            <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 p-6">
                {{ session()->get('message') }}
            </div>
        @endif
        <section class="text-gray-400 body-font">
            {{--     Movie Summary Section       --}}
            <div class="container mx-auto flex px-10 py-32 md:flex-row flex-col items-center">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <div class="flex justify-center mb-6">
                        <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-300">
                            <span class="text-gray-200 mx-2 whitespace-nowrap">{{ $movies->first()->year }}</span>
                        </div>
                        <div class="flex items-center ml-5 px-4 py-2 font-medium text-white tracking-wide capitalize transition-colors duration-200 transform bg-blue-600 rounded-md focus:outline-none focus:bg-blue-500">
                            <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#fff">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="whitespace-nowrap font-normal"> {{$movies->first()->average_rating}} / 10 </span>
                        </div>
                    </div>
                    <a href={{ route("movies.show", $movies->first()->id) }}>
                        <h1 class="title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-100"> {{ $movies->first()->title }}  </h1>
                    </a>
                    <div class="flex justify-center mb-6">
                        <div class="flex items-center py-2 font-medium tracking-wide">
                            <span class="mx-2 text-gray-200 whitespace-nowrap">
                                {{$movies->first()->duration}}
                            </span>
                            <span class="whitespace-nowrap font-normal">
                                <span class="mx-4 whitespace-nowrap">|</span>
                                @foreach($movies->first()->genres as $genre)
                                    <span class="text-gray-300">{{$genre->name}}@if (!$loop->last),@endif</span>
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
                            <a href="{{$movies->first()->trailer }}"><span class="mx-2 whitespace-nowrap">Play Trailer</span></a>
                        </button>
                        @if(auth()->check())
                            <form method="post" action="{{ route('watchlist.store', ['user'=>auth()->user()->id, 'movie'=>$movies->first()->id]) }}">
                                @csrf
                                <button value="{{$movies->first()->id}}" name="movie_id" class="flex items-center ml-5 px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-transparent rounded-md hover:bg-gray-800 focus:outline-none focus:bg-blue-500">
                                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f8f8f8">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    <span class="text-gray-300 mx-2 whitespace-nowrap font-normal">Add to Watchlist</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div>
        <div class="container p-14 mx-auto">
            @if(session('status'))
                <div class="w-full text-indigo-500 bg-indigo-100 border border-2 border-indigo-400 rounded rounded-md p-6 mb-12">
                    {{ session('status') }}
                </div>
            @endif
            <div class="flex justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Popular Movies</span>
                </div>
                <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-300">
                    <a href="{{ route('movies.index') }}"><span class="mx-2 whitespace-nowrap">All movies</span></a>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($movies as $movie)
                        <a href="{{ route('movies.show', $movie->id) }}">
                            <div class="w-full max-w-xs text-center">
                                <img class="object-cover object-center w-full h-80 mx-auto rounded-lg" src={{$movie->poster}} alt="movie_poster"/>
                                <div class="mt-2 flex justify-between">
                                    <span class="text-lg font-medium text-gray-700 ">{{$movie->title}}</span>
                                    <span class="mt-1 font-medium text-gray-600">{{$movie->average_rating}}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container p-14 mx-auto">
            <div class="flex justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Trending Celebs</span>
                </div>
                <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-300">
                    <a href="{{ route('celebs.index') }}"><span class="mx-2 whitespace-nowrap">All Celebs</span></a>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($celebs as $celeb)
                        <a href="{{ route('celebs.show', $celeb->id) }}">
                            <div class="w-full max-w-xs text-center">
                                <img class="object-cover object-center w-full h-80 mx-auto rounded-lg" src={{$celeb->photo}} alt="movie_poster"/>
                                <div class="mt-2 flex">
                                    <span class="text-lg font-medium text-gray-700 ">{{$celeb->name}}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
