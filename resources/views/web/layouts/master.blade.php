<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') ?? 'SIOMS' }}</title>

    {{-- Favicon & App Icons --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Tailwind (if using CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    {{-- If you're using Vite --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Scroll Animation Styles --}}
    <style>
        .scroll-fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .scroll-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .scroll-slide-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .scroll-slide-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        .scroll-slide-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .scroll-slide-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
        html {
            scroll-behavior: smooth;
        }
    </style>

    @livewireStyles

    @yield('styles')
</head>

<body class="bg-gray-50 antialiased">

    {{-- Header --}}
    @include('web.layouts.header')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('web.layouts.footer')

    @livewireScripts
    
    {{-- Scroll Animation Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-fade-in, .scroll-slide-left, .scroll-slide-right').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
