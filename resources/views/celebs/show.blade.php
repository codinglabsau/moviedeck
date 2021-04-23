@extends('layouts.app')

@section('content')

    <div class="container flex justify-between px-6 py-10 mx-auto space-y-6 md:h-128 md:py-16 md:items-center md:space-x-6">
        <div class="max-w-lg w-full md:w-1/2 h-full flex flex-col">
            <h1 class="text-2xl flex items-start font-medium tracking-wide text-gray-800 md:text-4xl">Titles</h1>
            <div>
                @foreach ($celeb->movies as $title)
                    <div class="flex items-center justify-between py-2 space-x-6 text-gray-800">
                        <img class="object-fit w-16 h-20 rounded-md" src="{{$title->poster}}" alt="movie_poster">
                        <span class="flex">{{$title->pivot->character_name}}</span>
                        <span class=" flex italic">{{$title->title}}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-bottom">
                @if(Auth::check() && Auth::user()->is_admin)
                    <button type="button" onclick="document.location='{{ route("celebs.edit", $celeb->id) }}'" class="flex items-center mt-16 mr-4 px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                        <span class="mx-2 whitespace-nowrap">{{ __('Edit Celeb') }}</span>
                    </button>
                    <form method="POST" action="{{ route('celebs.destroy', $celeb->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" style= "cursor:pointer" class="flex items-center mt-16 px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500" value="Delete Celeb">
                    </form>
                @endif
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full md:w-1/2">
            <img class="w-3/4 h-3/4 rounded-md" src="{{$celeb->photo}}" alt="actor photo">
            <p class="text-lg mt-3 md:text-2xl">{{$celeb->name}}</p>
        </div>
    </div>

@endsection
