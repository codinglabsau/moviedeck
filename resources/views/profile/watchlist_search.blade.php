@extends('layouts.app')

@section('title', 'MovieDeck | Add a Watchlist Item')

@section('content')
    <div class="flex flex-col my-20 w-full items-center">
        <h1 class="flex justify-center w-full title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500">Search for a movie to add to your watchlist</h1>
        <form method="POST" action="{{ route('profile.watchlistCreate', $user->id) }}" class="w-5/6">
            @csrf
            <input id="search" name="search" type="text" value="{{ old('search') }}" class="@error('search') is-invalid @enderror flex w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Search">
            @error('search')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
            @enderror
        </form>
    </div>
@endsection
