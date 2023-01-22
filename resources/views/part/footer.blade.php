<footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
    <div class="mx-auto max-w-screen-xl text-center">
        <x-logo class="flex justify-center"/>
        <p class="my-6 text-gray-500 dark:text-gray-400">
            {{ __('Scanner (screener) of bundles and spreads for cryptocurrency arbitrage on exchanges') }}
        </p>
        <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
            @foreach (config('app.main_nav') as $item)
                <li>
                    <a href="{{ Route::has($item['route']) ? route($item['route'],$item['params'] ?? []) : '' }}"
                       class="mr-4 hover:underline md:mr-6 ">
                        {{ __($item['title']) }}
                    </a>
                </li>
            @endforeach
        </ul>
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->format('Y') }}
            <a href="#"
               class="hover:underline">{{ config('app.name') }}</a>. {{ __("All Rights Reserved") }}.</span>
    </div>
</footer>
