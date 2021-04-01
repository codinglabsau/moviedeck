@extends('layouts/app')

@section('content')
    <div class="container px-14 py-16 mt-4 mx-auto w-full">
        <h1 class="text-xl font-bold text-gray-400">Favourite Celebs</h1>
    </div>
    <div class="container p-14 mx-auto">
        <div class="flex items-baseline justify-center">
            <div class="grid gap-8 mt-0 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($celebs as $celeb)
                    <div class="w-full max-w-xs text-center">
                        <img class="object-cover object-center w-full h-80 mx-auto rounded-lg" src={{$celeb->photo}} alt="movie_poster"/>

                        <div class="mt-2 flex">
                            <span class="text-lg font-medium text-gray-700 ">{{$celeb->name}}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex justify-center mb-4">
        {{$celebs->links()}}
    </div>
@endsection
