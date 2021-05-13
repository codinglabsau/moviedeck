@extends('layouts.app')

@section('title', 'MovieDeck | Add a Watchlist Item')

@section('content')
    <div class="flex flex-col my-20 w-full items-center">
        <h1 class="flex justify-center w-full title-font sm:text-6xl text-5xl mb-4 font-medium text-gray-500">Search for a movie to add to your watchlist</h1>
        <form method="POST" action="{{ route('profile.watchlistCreate', $user->id) }}" class="w-5/6">
            @csrf
            <input id="search" name="search" type="text" value="{{ old('search', $validated) }}" class="flex w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" placeholder="Search">
        </form>
    </div>
    <div class="container px-6 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex justify-between mb-12">
                <div class="flex pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-400 text-4xl whitespace-nowrap">Movies with <i>{{$validated}}</i> in the title</h1>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="grid gap-12 mt-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($output as $item)
                        <div>
                            <a href="{{ route('profile.watchlistStore', ['user'=>$user->id, 'movie'=>$item->id]) }}">
                                <img class="object-cover w-60 h-full" src="{{ $item->poster }}" alt="{{ $item->poster }}">
                                <h3>{{ $item->title}}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center py-20">
                {{ $output->links() }}
            </div>
        </div>
    </div>
@endsection
