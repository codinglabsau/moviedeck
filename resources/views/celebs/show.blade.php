@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 p-6 mb-12">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="container flex justify-between px-6 py-10 mx-auto space-y-6 md:h-128 md:py-16 md:items-center md:space-x-6">
        <div class="max-w-lg w-full md:w-1/2 h-full flex flex-col">
            <div class="flex justify-between">
                <h1 class="text-2xl flex items-start font-medium tracking-wide text-gray-800 md:text-4xl">Titles</h1>
                @if(Auth::check() && Auth::user()->is_admin)
                    <button type="button" class="flex text-gray-600 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                        <span class="mx-2 px-4 whitespace-nowrap">{{ __('Add Title') }}</span>
                    </button>
                @endif
            </div>
            @foreach ($titles as $title)
                <div class="flex items-center justify-between py-2 space-x-6 text-gray-800">
                    <img class="object-fit w-16 h-20" src="{{$title->poster}}" alt="movie_poster">
                    <span class="flex">{{$title->pivot->character_name}}</span>
                    <span class="flex italic">{{$title->title}}</span>
                </div>
            @endforeach
            <div>
                <div class="flex justify-center mt-3">
                    {{$titles->links()}}
                </div>
                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="flex justify-center">
                        <button type="button" onclick="document.location='{{ route("celebs.edit", $celeb->id) }}'" class="flex items-center mt-16 mr-4 px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <span class="mx-2 whitespace-nowrap">{{ __('Edit Celeb') }}</span>
                        </button>
                        <form method="POST" action="{{ route('celebs.destroy', $celeb->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" style="cursor:pointer" class="flex items-center mt-16 px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500" value="Delete Celeb">
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full md:w-1/2">
            <img class="w-3/4 h-3/4" src="{{$celeb->photo}}" alt="celeb_photo">
            <p class="text-lg mt-3 md:text-2xl">{{$celeb->name}}</p>
        </div>
    </div>
@endsection
