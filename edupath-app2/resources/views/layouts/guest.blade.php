<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @php
            $candidates = [
                'images/dorsu-logo.png','images/dorsu-logo.webp','images/dorsu-logo.jpg',
                'dorsu-logo.png','dorsu-logo.webp','dorsu-logo.jpg','logo.png','logo.jpg'
            ];
            $bgLogo = null;
            foreach ($candidates as $c) { if (file_exists(public_path($c))) { $bgLogo = asset($c); break; } }
            if (!$bgLogo && is_dir(public_path('images'))) {
                $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
                if (!empty($any)) { $bgLogo = asset('images/'.basename($any[0])); }
            }
        @endphp

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative"
             @if($bgLogo) style="background-image:url('{{ $bgLogo }}'); background-size:cover; background-position:center;" @endif>
            <div class="absolute inset-0 bg-white/70 dark:bg-black/60"></div>

            <div class="relative z-10 flex flex-col items-center">
                <a href="/">
                    <x-application-logo class="w-10 h-10 mx-auto" />
                </a>
                <div class="mt-3 text-center text-xl font-semibold">Baganga Campus</div>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
