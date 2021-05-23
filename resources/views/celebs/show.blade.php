@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 p-6 mb-12">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="container mx-auto mt-12">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-5 md:flex-row flex-col items-start align-top">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <div class="w-full flex justify-between items-center">
                        <div>
                            <h1 class="font-medium text-gray-700 text-4xl my-10">Titles</h1>
                        </div>
                    </div>
                    @foreach ($titles as $title)
                        <div class="flex w-full justify-between">
                            <div class="flex">
                                <a href="{{ route('movies.show', $title) }}"><img class="h-16 border rounded-sm my-2" src="{{ $title->poster }}" alt="{{ $title->title }}"></a>
                                <span class="p-6 font-medium"> <a href="{{ route('movies.show', $title) }}">{{ $title->title }}</a> </span>
                            </div>
                            <div class="flex">
                                <span class="p-6 font-light">
                                    as {{ $title->pivot->character_name }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex w-full justify-left my-12">
                        {{$titles->links()}}
                    </div>
                </div>
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col items-end mb-16 md:mb-0">
                    <div class="flex-col py-6">
                        <img class="w-80 rounded-md" src="{{ $celeb->photo }}" alt="celeb_photo">
                        <div class="flex flex-row">
                            @if (auth()->check() && auth()->user()->is_admin)
                                <div class="items-center align-bottom py-2">
                                    <a href="{{ route('celebs.edit', $celeb) }}">
                                        <button class="bg-blue-600 hover:bg-blue-500 rounded rounded-sm text-white">
                                            <span class="mx-2 whitespace-nowrap">Edit</span>
                                        </button>
                                    </a>
                                </div>
                                <div class="items-center align-middle px-2 py-2">
                                    <form method="POST" action="{{ route('celebs.destroy', $celeb) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-gray-300 rounded rounded-sm text-gray-500 hover:text-gray-600" type="submit">
                                            <span class="mx-2 whitespace-nowrap">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-row items-center py-1 mt-6 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm pl-2"> {{ $celeb->name }} </span>
                        </div>
                        <div class="flex flex-row items-center py-1 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                            </svg>
                            <span class="text-sm pl-2"> {{ \Carbon\Carbon::parse($celeb->date_of_birth)->format('d/m/Y')}} ({{ \Carbon\Carbon::parse($celeb->date_of_birth)->age }} years old) </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
