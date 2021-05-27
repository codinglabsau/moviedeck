@extends('layouts.app')

@section('title', 'MovieDeck | Give reviews to your fave movies!')

@section('content')
    <div class="container px-6 py-3 mx-auto md:flex">
        <div class="text-gray-600 body-font">
            <div class="flex flex-col mb-12 pt-24">
                <div class="flex pr-4 py-2 font-medium text-white tracking-wide capitalize">
                    <h1 class="font-medium text-gray-500 text-4xl whitespace-nowrap">Latest Reviews</h1>
                </div>
            </div>
            <div class="flex items-baseline justify-center">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0">
                    @if(session('message'))
                        <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 rounded rounded-md p-6 mb-12">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="grid gap-12 mt-0 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-stretch">
                        @foreach($reviews as $review)
                            <div class="bg-white rounded rounded-sm p-4">
                                <div class="flex flex-col my-4 mx-auto items-center">
                                    <a href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                        <img class="flex h-60 border rounded-sm" src="{{ $review->movie->poster }}" alt="{{ $review->movie->title }}">
                                        <h1 class="text-sm font-semibold py-4">{{ $review->movie->title }}</h1>
                                    </a>
                                </div>
                                <div class="p-4">
                                    <a href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                        <h1 class="font-bold text-lg tracking-wide">
                                            <svg class="w-5 h-5 inline-flex align-top" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            <span>{{ $review->rating }}</span>
                                            <span class="font-normal text-sm">/ 10</span> </h1>
                                        <h2 class="font-medium pt-2 text-md"> {{ $review->title }} </h2>
                                    </a>
                                    <a href="{{ route('profile.dashboard', $review->user->id) }}">
                                        <span class="font-bold text-sm text-blue-500 mr-4"> {{ $review->user->username }} </span>
                                    </a><br/>
                                    <span class="font-normal text-sm"> {{ $review->created_at->diffForHumans() }} </span>
                                    <p class="mt-6">
                                        {{ $review->excerpt }}
                                        @if(strlen($review->content) > 200)
                                            <button><a class="flex flex-col text-sm text-blue-400 hover:text-blue-500" href="{{ route('reviews.show', ['movie' => $review->movie->id, 'review' => $review]) }}">Read More</a></button>
                                        @endif
                                    </p>
                                </div>
                                @if (auth()->check())
                                    <div class="flex flex-row">
                                        @if(request()->user()->id === $review->user->id)
                                            <div class="items-center align-bottom py-2">
                                                <a href="{{ route('reviews.edit', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                                    <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                                        <span class="mx-2 whitespace-nowrap">Edit</span>
                                                    </button>
                                                </a>
                                            </div>
                                        @endif
                                        @if (request()->user()->id === $review->user->id || request()->user()->is_admin)
                                            <div class="items-center align-middle px-2 py-2">
                                                <form method="POST" action="{{ route('reviews.destroy', ['movie' => $review->movie->id, 'review' => $review]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="bg-gray-300 rounded rounded-sm text-gray-500 hover:text-gray-600" type="submit">
                                                        <span class="mx-2 whitespace-nowrap">Delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex justify-center py-20">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
