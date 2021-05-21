@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="w-full text-green-500 bg-green-100 border border-2 border-green-400 p-6 mb-12">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="w-full px-6 py-3 mx-auto ml-10">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-5 md:flex-row flex-col items-start align-top">
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <div class="w-full flex justify-between items-center">
                        <div>
                            <h1 class="font-medium text-gray-500 text-4xl my-10">Titles</h1>
                        </div>
                        @if (auth()->check() && auth()->user()->is_admin)
                            <button type="button" class="h-8 flex text-gray-600 items-center font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                                <span class="mx-2 px-4 whitespace-nowrap">{{ __('Add Title') }}</span>
                            </button>
                        @endif
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
                    <div class="flex w-full justify-center mt-3">
                        {{$titles->links()}}
                    </div>
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div class="flex">
                            <button type="button" onclick="document.location='{{ route("celebs.edit", $celeb->id) }}'" class="flex items-center mt-16 mr-4 px-2 py-2 font-medium tracking-wide text-gray-600 capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500">
                                <span class="mx-2 whitespace-nowrap">{{ __('Edit Celeb') }}</span>
                            </button>
                            <form method="POST" action="{{ route('celebs.destroy', $celeb->id) }}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" style="cursor:pointer" class="flex items-center mt-16 px-2 py-2 font-medium tracking-wide text-gray-600 capitalize transition-colors duration-200 transform rounded-md border-2 border-gray-700 hover:border-gray-500" value="Delete Celeb">
                            </form>
                        </div>
                    @endif
                </div>
                <div class="w-full lg:pr-24 md:pr-16 flex flex-col items-end mb-16 md:mb-0">
                    <div class="flex-col py-6">
                        <img class="w-80 rounded-md" src="{{ $celeb->photo }}" alt="celeb_photo">
                        <h2 class="font-medium text-gray-800 text-2xl pt-4">Name: {{ $celeb->name }}</h2>
                        <h2 class="font-medium text-gray-800 text-2xl">Born: {{ \Carbon\Carbon::parse($celeb->date_of_birth)->format('d/m/Y')}}</h2>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
