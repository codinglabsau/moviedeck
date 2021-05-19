@extends('layouts.app')

@section('title', 'MovieDeck | Find the best movies!')

@section('content')
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-start align-top">
        <div class="flex flex-col w-3/4 md:items-start md:text-left mr-10 mb-16 md:mb-0 items-center text-center bg-white p-12">
            <h1 class="font-medium text-gray-500 text-4xl mb-6">Edit
                <span class="text-blue-500">
                    <a href="{{ route('movies.show', $movie) }}" target="_blank">{{ $movie->title }}</a>
                </span>
            </h1>
            @if ($errors->any())
                <div class="text-red-500 bg-red-100 border border-2 border-red-400 rounded rounded-md p-6 m-2 w-full">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="flex w-full justify-between">
                <form method="POST" action="{{ route('movies.update', $movie) }}" class="mx-auto w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="title"> Title:
                                    <input type="text" name="title" value="{{ $movie->title }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </label>
                            </div>
                            <div class="w-1/2">
                                <label for="year"> Year:
                                    <input type="text" name="year" value="{{ $movie->year }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm text-gray-400"> 4-digit format </span>
                                </label>
                            </div>
                        </div>

                        <label for="synopsis"> Synopsis:
                            <textarea type="text" name="synopsis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $movie->synopsis }}</textarea>
                        </label>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="poster"> Poster:
                                    <input type="text" name="poster" value="{{ $movie->poster }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm text-gray-400"> Photo URL </span>
                                </label>
                            </div>
                            <div class="w-1/2">
                                <label for="banner"> Banner:
                                    <input type="text" name="banner" value="{{ $movie->banner }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm text-gray-400"> Photo URL </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex py-6">
                            <div class="w-1/2">
                                <label for="trailer"> Trailer:
                                    <input type="text" name="trailer" value="{{ $movie->trailer }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm text-gray-400">YouTube, Vimeo, etc. </span>
                                </label>
                            </div>
                            <div class="w-1/2">
                                <label for="duration"> Duration:
                                    <input type="text" name="duration" value="{{ $movie->raw_duration }}" class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm text-gray-400">in minutes</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-6 mt-16">
                        <h1 class="font-medium text-gray-500 text-2xl" id="genres">Genres</h1>
                        <span class="text-sm text-gray-400 py-4"> Select one or more genre: </span>
                    </div>
                    <div class="h-auto grid grid-rows-3 grid-flow-col gap-2">
                        @foreach($genres as $genre)
                            <label class="inline-flex items-center mt-3">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       {{ $movie->genres->contains($genre->id) ? 'checked' : '' }}
                                       @if(in_array($genre->id,old('genres',[]))) checked  @endif
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-600 font-medium text-md">{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div x-data="casts()">
                        <div class="flex justify-between mb-6 mt-16">
                            <div>
                                <h1 class="font-medium text-gray-500 text-2xl mb-4" id="casts">Casts</h1>
                                <span class="text-sm text-gray-400 py-4"> Select from our list of celebrities and add/remove casts: </span>
                            </div>
                            <div>
                                <button type="button" @click="addNewCast()" class="flex w-max px-6 py-2 leading-5 text-gray-700 text-sm border border-gray-700 rounded-md">+Add More</button>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <template x-for="cast, index in casts" :key="index">
                                <div class="flex flex-row">
                                    <div x-text="index + 1" class="text-gray-400 py-4"></div>
                                    <select x-model="cast.celebId" name="celebs[]"
                                            class="form-select ml-6 mr-3 h-12 w-1/3 mt-1 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                                        <option value="">Select a celebrity</option>
                                        @foreach($celebs as $celebOption)
                                            <option value="{{ $celebOption->id }}" @if($movie->celebs->contains($celeb->id && $celebOption->id == $celeb->id)) selected @endif>{{ $celeb->name }}</option>
                                        @endforeach
                                    </select>
                                    <input x-model="cast.castName" type="text" name="characters[]" value="{{ $celeb->pivot->character_name }}"
                                           class="mt-1 h-12 w-full align-middle rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <button type="button" @click="removeCast(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-4" fill="none" viewBox="0 0 24 24" stroke="#8c8c8c">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
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
        function casts() {
            return {
                casts: [{{$movie->celebs}}],
                celebId: '',
                castName: '',
                addNewCast() {
                    this.casts.push({
                        celebId: '',
                        castName: '',
                    });
                },
                removeCast(index) {
                    this.casts.splice(index, 1);
                }
            }
        }
    </script>
@endsection
