@extends('layouts.app')

@section('title', 'MovieDeck | My Profile')

@section('content')
    <div class="flex w-3/4 my-24 mx-auto bg-white shadow-md">
        {{-- Side Nav Bar --}}
        <div class="flex flex-col w-1/5 pb-8 bg-gray-600 border-r">
            <div class="flex flex-col items-start justify-end bg-cover bg-center w-full h-36 lg:h-72" style="background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(27, 28, 32, 1)), url({{asset($user->avatar)}})">
                <div class="lg:flex justify-between w-full">
                    <div>
                        <h4 class="mx-3 mt-2 md:text-base text-sm font-medium text-gray-100">{{$user->username}}</h4>
                        <p class="mx-3 mb-2 hidden lg:block md:text-sm text-xs text-gray-300 ">{{$user->email}}</p>
                    </div>
                    @if (auth()->user()->id === $user->id || auth()->user()->is_admin)
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

            <h3 class="mx-4 mt-4 md:whitespace-nowrap flex text-gray-100 items-center font-semibold tracking-wide capitalize">{{$user->name}}</h3>
            <p class="mx-4 hidden lg:block text-gray-300 text-sm">{{$user->about_me}}</p>

            @if (auth()->user()->id === $user->id)
                <div class="flex flex-col justify-between flex-1 mt-6">
                    <nav>
                        <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform hover:bg-gray-700 hover:text-gray-200" href="{{ route('profile.dashboard', $user->id) }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="mx-4 hidden lg:block">Dashboard </span>
                        </a>

                        <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform bg-gray-700 hover:text-gray-200" href="{{ route('profile.reviews', $user->id) }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="mx-4 hidden lg:block font-bold">Reviews</span>
                        </a>
                        @if (auth()->user()->id === $user->id)
                            <a class="flex items-center pl-4 p-2 text-gray-100 transition-colors duration-200 transform hover:bg-gray-700 hover:text-gray-200" href="{{ route('watchlist.index', $user->id) }}">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="mx-4 hidden lg:block">Watchlist</span>
                            </a>
                        @endif
                    </nav>
                </div>
                <div class="mt-12">
                    <span class="ml-4 text-gray-300 text-sm"> Need Help? <span class="font-bold text-gray-100"><a href="#">Contact us</a></span></span>
                </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="w-4/5 mx-4 md:mx-24 my-14">
            <div class="lg:flex justify-between">
                <span class="font-medium text-gray-800 whitespace-nowrap capitalize md:text-2xl">Recent Reviews</span>
                <div class="flex items-center px-4 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-900">
                    <span class="mx-2 whitespace-nowrap">{{$reviews->total()}} Reviews</span>
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="grid gap-x-24 gap-y-12 mt-14 sm:grid-cols-1 lg:grid-cols-2">
                    @foreach($reviews as $review)
                        <div class="flex">
                            <div class="flex flex-col">
                                <a href="{{ route('movies.show', $review->movie->id) }}">
                                    <img class="object-cover object-center flex justify-start w-24 h-32" src={{$review->movie->poster}} alt="movie_poster"/>
                                </a>
                            </div>
                            <div class="mt-1 flex flex-col items-start ml-6">
                                <div class="flex my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 self-center" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="font-semibold text-base text-gray-600 self-start">{{ $review->rating . ' ' }} </span> <span class="self-center text-sm text-gray-400"> / 10 </span>
                                </div>
                                <a href="{{ route('reviews.show', ['movie'=>$review->movie->id, 'review'=>$review->id]) }}" class="hover:text-gray-500 text-base font-normal text-left leading-none text-gray-600">
                                    {{$review->title}}
                                </a>
                                <div class="flex mt-1 text-left leading-none justify-start">
                                    <span class="font-bold text-sm text-blue-600">{{$review->user->username}}</span>
                                    <span class="ml-3 text-gray-400">{{$review->created_at->format('M d')}}</span>
                                </div>
                                @if(auth()->user()->id === $user->id)
                                    <div class="font-medium flex text-gray-600 mt-4">
                                        <a href="{{ route('reviews.edit', ['movie'=>$review->movie->id, 'review'=>$review->id]) }}" class="hover:text-gray-500">Edit</a>
                                        <span class="px-2">|</span>
                                        <form method="post" action="{{ route('reviews.destroy', ['movie'=>$review->movie->id, 'review'=>$review->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="font-medium text-gray-600 hover:text-gray-500">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end pt-20">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
