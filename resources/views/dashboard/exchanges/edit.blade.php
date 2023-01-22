<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exchanges') }}
            </h2>
            <a href="{{ route('exchanges.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{__('Go to exchanges')}}
            </a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <form class="p-4" action="{{ route('exchanges.update',$exchange->id) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                            <input type="text" id="name"
                                   name="name"
                                   value="{{ $exchange->name }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="">
                            @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap w-full mb-6">
                        <label for="logo"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">{{ __("Logo") }}</label>
                        <figure class="basis-1/6 border p-2 mr-4">
                            @if($exchange->logo_url && \Storage::disk('public')->exists($exchange->logo_url))
                                <img class="h-auto w-full mx-auto" src="{{ asset('storage/'.$exchange->logo_url) }}"
                                     alt="{{ $exchange->name }}">
                            @else
                                <img class="h-auto w-full mx-auto" src="{{ asset('img/no-image.png') }}"
                                     alt="{{ __('No image') }}">
                            @endif
                        </figure>

                        <div class="basis-auto">

                            <input type="file" id="logo"
                                   name="logo"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full"
                                   placeholder="">
                            @error('logo')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="slug"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                            <input type="text" id="slug"
                                   name="slug"
                                   value="{{ $exchange->slug }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="">
                            @error('slug')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="trade_link"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Ссылка на окно торговли") }}</label>
                            <input type="text" id="trade_link"
                                   name="trade_link"
                                   value="{{$exchange->trade_link}}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="">
                            @error('trade_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __("Submit") }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
