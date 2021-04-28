@extends('layouts.app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
        <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
            <h1 class="font-medium text-gray-500 text-4xl mb-6">Add a Movie
            </h1>
            @if ($errors->any())
                <div class="text-red-500 bg-red-100 border border-2 border-red-400 rounded rounded-md p-6 m-2 w-full">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="flex w-full justify-between">
                <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data" class="mx-auto w-full">
                    @csrf
                    <div class="flex flex-col">
                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="title"> Title: </label>
                                <input type="text" name="title" class="w-auto mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                            <div class="w-1/2">
                                <label for="year"> Year: </label>
                                <input type="text" name="year" class="w-auto mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                        </div>

                        <label for="synopsis"> Synopsis: </label>
                        <textarea type="text" name="synopsis" class="my-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light"></textarea>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="poster"> Poster: </label>
                                <input type="file" name="poster" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                            <div class="w-1/2">
                                <label for="banner"> Banner: </label>
                                <input type="file" name="banner" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                        </div>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="trailer"> Trailer: </label>
                                <input type="text" name="trailer" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                            <div class="w-1/2">
                                <label for="duration"> Duration: </label>
                                <input type="text" name="duration" class="mx-4 outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row mt-6 align-middle items-center">
                            <button type="submit" class="flex w-max px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Add</button>
                            <a class="text-gray-400 hover:text-gray-600 px-4 py-2" href="{{ route('movies.index') }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-1/4 flex flex-col items-end mb-16 md:mb-0">
            <div class="flex-col pb-6">
                <img class="flex w-80 border rounded-sm mb-4 align-middle justify-end" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkyo0R2Y_RzD6pxe6RaMnwClgH0yheiyio6mOEacCl8RbwEnvB9rXGAqxUYxs5KJpObaU&usqp=CAU" alt="movie_poster_placeholder">
            </div>
        </div>
    </div>
@endsection
