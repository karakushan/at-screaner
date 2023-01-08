<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
<div class="container mx-auto">
    @livewire('coins-table')
</div>
@livewireScripts
</body>
</html>
