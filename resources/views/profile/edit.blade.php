@extends('layouts.app')

@section('title', 'MovieDeck | Edit your profile')

@section('content')
    <div class="w-full px-6 py-3 mx-auto">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
                <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
                    <h1 class="font-medium text-gray-500 text-4xl mb-12">Edit Profile Details</h1>
                    @if(session()->has('message'))
                        <div class="text-blue-500 bg-blue-100 border border-2 border-blue-400 rounded rounded-md p-6 w-full mb-8">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if (auth()->user()->id === $user->id)
                        <div class="flex w-full justify-between">
                            <form method="POST" action="{{ route('profile.update', $user) }}" class="mx-auto w-full">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-col pb-6">
                                    <label for="username" class="text-md font-medium py-2">Change your username</label>
                                    <input id="username" name="username" value="{{ $user->username }}" class="@error('username') is-invalid @enderror outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                    @error('username')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex flex-col pb-6">
                                    <label for="name" class="text-md font-medium py-2">Change your name</label>
                                    <input id="name" name="name" value="{{ $user->name }}" class="@error('name') is-invalid @enderror outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                    @error('name')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex flex-col pb-6">
                                    <label for="avatar" class="text-md font-medium py-2">Edit your avatar URL</label>
                                    <input id="avatar" name="avatar" value="{{  $user->avatar }}" class="@error('avatar') is-invalid @enderror outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">
                                    @error('avatar')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex flex-col pb-6">
                                    <label for="about_me" class="text-md font-medium py-2">About me</label>
                                    <textarea id="about_me" name="about_me" cols="60" rows="5" class="@error('about_me') is-invalid @enderror outline-none border border-4 border-gray-200 text-gray-700 rounded rounded-md p-2 text-md font-light">{{ $user->about_me }}</textarea>
                                    @error('about_me')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex flex-row mt-6 align-middle items-center">
                                    <button type="submit" class="flex w-max px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Apply</button>
                                    <a class="text-gray-400 hover:text-gray-600 px-4" href="{{ route('profile.dashboard', $user->id) }}">Cancel</a>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if(auth()->user()->is_admin && auth()->user()->id !== $user->id)
                        <h1 class="font-medium text-gray-700 text-lg my-2">{{$user->name}}</h1>
                        @if($user->is_admin)
                            <div class="flex flex-row">
                                <h3 class="whitespace-nowrap flex text-gray-100 text-base items-center font-normal tracking-wide capitalize"><span class="bg-blue-600 py-1 px-2 rounded-xl">Admin</span></h3>
                                <form method="POST" action="{{ route('profile.removeAdmin', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button name="remove_admin" class="h-8 flex text-gray-400 hover:text-gray-600 items-center font-normal tracking-wide transition-colors duration-200 transform rounded-md">
                                        <span class="mx-2 whitespace-nowrap text-base">Remove as Admin</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex flex-row">
                                <h3 class="whitespace-nowrap flex text-gray-100 text-base items-center font-normal tracking-wide capitalize"><span class="bg-green-600 py-1 px-2 rounded-xl">Member</span></h3>
                                <form method="POST" action="{{ route('profile.makeAdmin', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button name="make_admin" class="h-8 flex text-gray-400 hover:text-gray-600 items-center font-normal tracking-wide transition-colors duration-200 transform rounded-md">
                                        <span class="mx-2 whitespace-nowrap text-base">Make Admin</span>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="w-1/2 md:w-1/4 flex flex-col items-end mb-16 md:mb-0">
                    <a href="{{route('profile.reviews', $user->id)}}">
                        <div class="flex-col pb-6">
                            <img class="flex w-72 h-96 border rounded-sm mb-4 align-middle justify-end object-cover" src="{{ asset($user->avatar) }}" alt="avatar">
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
