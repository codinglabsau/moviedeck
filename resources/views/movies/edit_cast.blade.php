@extends('layouts.app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
        <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
            <h1 class="font-medium text-gray-500 text-4xl mb-6"> Add casts to
                <span class="text-blue-500">
                    <a href="{{ route('movies.show', $movie) }}" target="_blank">{{ $movie->title }}</a>
                </span>
            </h1>
            <span class="text-sm text-gray-400 py-4"> Select from our list of celebrities: </span>
            @if ($errors->any())
                <div class="text-red-500 bg-red-100 border border-2 border-red-400 rounded rounded-md p-6 m-2 w-full">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="w-full flex justify-between">
                <form method="POST" action="{{ route('movies.update.cast', $movie) }}" class="mx-auto w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        @foreach($celebs as $celeb)
                            <div>
                                <label class="flex flex-row justify-between align-middle mt-3">
                                    <div>
                                        <input {{ $celeb->value ? 'checked' : null }}
                                               data-id="{{ $celeb->id }}" type="checkbox"
                                               {{ $movie->celebs->contains($celeb->id) ? 'checked' : '' }}
                                               @if(in_array($celeb->id,old('celebs',[]))) checked  @endif
                                               class="celeb-enable rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-gray-600 font-medium text-md align-middle">{{ $celeb->name }}</span>
                                    </div>
                                    <input @if( $movie->celebs->contains($celeb->id) ) value="{{ $movie->celebs->find($celeb->id)->pivot->character_name }}" @endif
                                           data-id="{{ $celeb->id }}" name="celebs[{{ $celeb->id }}]" type="text" placeholder="as character"
                                           class="celeb-character form-control mt-1 mx-2 align-middle w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:bg-green-200"
                                           value="{{ $celeb->value ?? null }}" {{ $celeb->value ? null : 'disabled' }} >
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row mt-6 align-middle items-center">
                            <button type="submit" class="flex w-max px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Update</button>
                            <a class="text-gray-400 hover:text-gray-600 px-4 py-2" href="{{ route('movies.show', $movie) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-1/4 flex flex-col items-end mb-16 md:mb-0">
            <div class="flex-col pb-6">
                <img class="flex w-80 border rounded-sm mb-4 align-middle justify-end" src="{{ $movie->poster }}" alt="{{ $movie->title }}">
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('document').ready(function () {
            $('.celeb-enable').on('click', function () {
                let id = $(this).attr('data-id')
                let enabled = $(this).is(":checked")
                $('.celeb-character[data-id="' + id + '"]').attr('disabled', !enabled)
                $('.celeb-character[data-id="' + id + '"]').val(null)
            })
        });
    </script>
@endsection
