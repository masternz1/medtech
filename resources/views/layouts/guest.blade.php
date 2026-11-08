<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MedTech Distributions') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans antialiased">
        <div class="flex min-h-screen flex-col items-center px-4 pt-10 sm:justify-center sm:pt-0">
            <a href="/" class="flex items-center gap-2.5 text-brand-600" aria-label="MedTech Distributions home">
                <x-application-logo class="h-10 w-10" />
                <span class="font-display text-xl font-bold text-ink">MedTech Distributions</span>
            </a>

            <div class="mt-6 w-full border-t-2 border-brand-600 bg-white px-7 py-7 sm:max-w-md">
                {{ $slot }}
            </div>

            <a href="/" class="mt-5 text-sm text-slate-600 hover:text-brand-700 hover:underline">Back to the shop</a>
        </div>
    </body>
</html>
