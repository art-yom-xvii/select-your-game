<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Select Your Game') }} - @yield('title', 'Video Games & Gaming Merchandise')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    @include('partials.header')

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="container mx-auto px-4 py-3 mt-4">
            <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mx-auto px-4 py-3 mt-4">
            <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        // Simple mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Update cart count - this would typically be done via AJAX or server-side
        function updateCartCount(count) {
            document.getElementById('cart-counter').textContent = count;
        }

        // Example: updateCartCount(5);
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>
</html>
