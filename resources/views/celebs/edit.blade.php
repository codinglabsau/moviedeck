@extends('layouts.app')

@section('content')
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
        <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
            <h1 class="font-medium text-gray-500 text-4xl mb-6">Edit
                <span class="text-blue-500">
                    <a href="{{ route('celebs.show', $celeb) }}" target="_blank">{{ $celeb->name }}</a>
                </span>
            </h1>
            <div class="flex w-full justify-between">
                <form method="POST" action="{{ route('celebs.update', $celeb->id) }}" class="mx-auto w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label class="text-gray-700" for="name">Name:</label>
                                <input id="name" name="name" type="text" value="{{old('name', $celeb->name)}}" class="@error('name') is-invalid @enderror block w-3/4 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring">
                                @error('name')
                                <div class="bg-red-100 my-3 w-3/4 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label class="text-gray-700" for="date_of_birth">Date of Birth</label>
                                <input id="date_of_birth" name="date_of_birth" type="date" value="{{old('date_of_birth', $celeb->date_of_birth)}}" class="@error('date_of_birth') is-invalid @enderror block w-3/4 px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                @error('date_of_birth')
                                <div class="bg-red-100 my-3 w-3/4 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <label class="text-gray-700 dark:text-gray-200" for="photo">Photo URL</label>
                        <input id="photo" name="photo" type="url" value="{{old('photo', $celeb->photo)}}" class="@error('photo') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring">
                        @error('photo')
                        <div class="bg-red-100 my-3 w-full border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col mt-10">
                        <div class="flex flex-row align-middle items-center">
                            <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Update</button>
                            <a class="text-gray-400 hover:text-gray-600 px-4 py-2" href="{{ route('celebs.show', $celeb) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-1/4 flex flex-col items-end mb-16 md:mb-0">
            <div class="flex-col pb-6">
                <img class="flex w-80 border rounded-sm mb-4 align-middle justify-end" src="{{ $celeb->photo }}" alt="{{ $celeb->name }}">
            </div>
        </div>
    </div>
@endsection
