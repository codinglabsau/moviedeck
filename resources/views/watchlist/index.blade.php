@extends('layouts.app')

@section('title', 'MovieDeck | My Profile')

@section('content')
    <div class="flex w-5/6 my-10 mx-auto bg-white shadow-md">
        {{-- Side Nav Bar--}}
        <div class="flex flex-col w-32 md:w-64 h-screen pb-8 bg-white border-r">
            <div class="flex flex-col items-start justify-end bg-cover bg-center w-32 h-32 md:w-64 md:h-64" style="background-image: url({{$user->avatar}})">
                <div class="flex justify-between w-full">
                    <div>
                        <h4 class="z-10 mx-3 mt-2 md:text-base text-sm font-medium text-gray-100">{{$user->name}}</h4>
                        <p class="z-10 mx-3 mb-2 md:text-sm text-xs text-gray-300 ">{{$user->email}}</p>
                    </div>
                    @if (Auth::user()==$user)
                        <a href="#" class="text-gray-400 flex items-center justify-end mr-4 hover:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex flex-col justify-between flex-1 mt-6">
                <nav>
                    <a class="flex items-center px-4 py-2 text-gray-600 transition-colors duration-200 transform hover:bg-gray-200 hover:text-gray-700" href="{{ route('profile.dashboard', $user->id) }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Dashboard</span>
                    </a>

                    <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-200 transform hover:bg-gray-200 hover:text-gray-700" href="{{ route('profile.reviews', $user->id) }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Reviews</span>
                    </a>
                    <div class="flex items-center px-4 py-2 mt-5 text-gray-700 bg-gray-200">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Watchlist</span>
                    </div>
                </nav>
            </div>
        </div>
        {{-- Content --}}
        <div class="flex flex-col">
            @if(session()->has('message'))
                <div class="w-full text-blue-500 bg-blue-100 border border-2 border-blue-400 p-6">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="container w-full px-14 py-5 mx-auto">
                <div class="flex w-full justify-between">
                    <span class="flex font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Watchlist</span>
                    <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-300 hover:border-gray-500">
                        <a href="{{ route('watchlist.create', $user->id) }}"><span class="mx-2 whitespace-nowrap">Add a Movie</span></a>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <div class="grid gap-12 mt-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        @foreach($watchlist as $item)
                            <div>
                                <a href="{{ route('movies.show', $item->id) }}">
                                    <img class="object-cover w-full h-30" src="{{ $item->poster }}" alt="{{ $item->poster }}">
                                </a>
                                <div class="flex justify-between">
                                    <h3>{{ $item->title }}</h3>
                                    <form method="post" action="{{ route('watchlist.destroy', ['user'=>$user->id, 'movie'=>$item->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button value="{{$item->id}}" name="movie_id" style="outline: none;" class="h-8 flex text-gray-500 items-center font-medium capitalize transition-colors duration-200 transform hover:text-gray-400 focus:text-gray-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-center py-20">
                    {{ $watchlist->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
