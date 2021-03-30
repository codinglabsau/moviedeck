@extends('layouts/app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container px-6 py-3 mx-auto md:flex">
        <section class="text-gray-600 body-font">
            <h1 class="font-medium text-gray-500 text-4xl px-5 pt-24">Popular Movies</h1>
            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="grid grid-flow-row sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-28">
                    @foreach($movies as $movie)
                        <div>
                            <a href="{{ url()->current() }}/{{ $movie->id }}">
                                <img class="w-48" src="{{ $movie->poster }}" alt="{{ $movie->poster }}">
                            </a>
                            <div class="flex justify-between">
                                <h3><a href="{{ url()->current() }}/{{ $movie->id }}"> {{ $movie->title }} </a></h3>
                                <h3> 4.8 </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
