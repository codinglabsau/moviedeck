@extends('layouts.app')

@section('title', 'MovieDeck | My Profile')

@section('content')
    <div class="flex w-3/4 my-24 mx-auto bg-white shadow-md">
        {{-- Side Nav Bar --}}
        <div class="flex flex-col w-1/5 pb-8 bg-gray-600 border-r">
            <div class="flex flex-col items-start justify-end bg-cover bg-center w-full h-72" style="background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(27, 28, 32, 1)), url({{asset($user->avatar)}})">
                <div class="flex justify-between w-full">
                    <div>
                        <h4 class="mx-3 mt-2 md:text-base text-sm font-medium text-gray-100">{{$user->name}}</h4>
                        <p class="mx-3 mb-2 md:text-sm text-xs text-gray-300 ">{{$user->email}}</p>
                    </div>
                    @if (auth()->user()==$user || auth()->user()->is_admin)
                        <a href="{{ route('profile.edit', $user->id) }}" class="text-gray-300 flex items-center justify-end mr-4 hover:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            @if($user->is_admin)
                <h3 class="mx-2 mt-4 p-1 whitespace-nowrap flex text-gray-200 text-sm items-center font-normal tracking-wide capitalize"><span class="bg-blue-600 py-1 px-2 rounded-xl">Admin</span></h3>
            @endif

            <p class="mx-4 mt-4 text-gray-300 text-sm">{{$user->about_me}}</p>

            <div class="flex flex-col justify-between flex-1 mt-6">
                <nav>
                    <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform hover:bg-gray-700 hover:text-gray-200" href="{{ route('profile.dashboard', $user->id) }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mx-4">Dashboard </span>
                    </a>

                    <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform hover:bg-gray-700 hover:text-gray-200" href="{{ route('profile.reviews', $user->id) }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mx-4">Reviews</span>
                    </a>
                    @if (auth()->user()->id === $user->id)
                        <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform bg-gray-700 hover:text-gray-200" href="{{ route('watchlist.index', $user->id) }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="mx-4 font-bold">Watchlist</span>
                        </a>
                    @endif
                </nav>
            </div>
            <div class="mt-12">
                <span class="ml-4 text-gray-300 text-sm"> Need Help? <span class="font-bold text-gray-100"><a href="#">Contact us</a></span></span>
            </div>
        </div>

        {{-- Watchlist --}}
        <div class="w-4/5 mx-24 my-14">
            <div class="flex w-full justify-between">
                <span class="flex font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Watchlist</span>
                <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize border-2 border-gray-800 rounded-md">
                    <a href="{{ route('watchlist.create', $user->id) }}"><span class="mx-2 whitespace-nowrap">Add a Movie</span></a>
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="grid gap-12 mt-14 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($watchlist as $item)
                        <div>
                            <a href="{{ route('movies.show', $item->id) }}">
                                <img class="object-cover w-40 h-60" src="{{ $item->poster }}" alt="{{ $item->poster }}">
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
@endsection
