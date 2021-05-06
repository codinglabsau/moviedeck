@extends('layouts.app')

@section('title', 'MovieDeck | Find your favourite celebrities!')

@section('content')
    @if(session()->has('message'))
        <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 p-6 mb-12">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="container px-6 py-3 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12 pt-24">
                <div class="flex pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-500 text-4xl whitespace-nowrap">Favourite Celebrities</h1>
                </div>
                @if (auth()->check() && auth()->user()->is_admin === true)
                    <div class="flex items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                        <a href="{{ route('celebs.create') }}" class="mx-2 px-4 whitespace-nowrap">Add Celeb</a>
                    </div>
                @endif
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
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
            <div class="flex justify-center py-20">
                {{ $celebs->links() }}
            </div>
        </div>
    </div>
@endsection
