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
 {{-- Font Awesome Icons --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 px-4">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <a href="/">
                        <img src="{{ asset('images/sioms-logo-horizontal-white.svg') }}"
                             alt="{{ config('app.name', 'SIOMS') }}"
                             class="h-10 w-auto drop-shadow-md">
                    </a>
                </div>

                <!-- Auth Card -->
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl px-8 py-8">
                    {{ $slot }}
                </div>

                <!-- Small footer -->
                <p class="mt-6 text-xs text-center text-blue-100">
                    © {{ date('Y') }} {{ config('app.name', 'SIOMS') }} — Smart Inventory &amp; Orders
                </p>
            </div>
        </div>
    </body>
</html>
