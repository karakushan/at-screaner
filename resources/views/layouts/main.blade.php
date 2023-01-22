<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ sprintf('%s | %s',$title ?? '',config('app.name')) }} </title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon') }}/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('img/favicon') }}/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('img/favicon') }}/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body class="antialiased dark">
@include('part.header')
<div class="mx-auto max-w-screen-xl mb-8">
    @yield('content')
</div>
@include('part.footer')
@livewireScripts
</body>
</html>
