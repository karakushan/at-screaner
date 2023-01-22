<div {{ $attributes }}>
    <a href="{{ route('home') }}" class="flex items-center">
        <img src="{{ asset('img/html-coin-html-logo.svg') }}" class="mr-3 h-6 sm:h-8" alt="Flowbite Logo"/>
        <span
            class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
    </a>
</div>
