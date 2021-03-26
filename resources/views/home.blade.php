@extends('layouts/app')

@section('content')
    <div class="container px-6 py-2 mx-auto md:flex">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex justify-between px-5 py-2 md:flex-row flex-col items-center">
                <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <p class=inline-flex>{{$top_rated->movie->year}}</p>
                    <p class=inline-flex>{{$top_rated->average_rating}}/10</p>
                    <h1 class="title-font sm:text-4xl text-4xl mb-4 font-small text-gray-900">
                        {{$top_rated->movie->title}}
                    </h1>
                    <p class="mb-8 leading-relaxed">{{intdiv($top_rated->movie->duration,60)}}hrs {{$top_rated->movie->duration%60}}min</p>
                    @foreach($top_rated->movie->genres as $genre)
                        <p>$genre->name</p>
                    @endforeach
                    <div class="flex justify-center">
                        <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Watch Trailer</button>
                        <button class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Add to Watchlist</button>
                    </div>
                </div>
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 flex items-center">
                    <img class="object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600">
                </div>
            </div>
        </section>
    </div>
@endsection
