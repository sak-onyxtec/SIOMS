<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') ?? 'SIOMS' }}</title>

    {{-- Tailwind (if using CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- If you're using Vite --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @livewireStyles

    @yield('styles')
</head>

<body class="bg-gray-100">

    <livewire:auth.register />

    @livewireScripts
</body>

</html>
