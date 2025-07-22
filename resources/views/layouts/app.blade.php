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
    @vite(['resources/js/layout.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    @include('partials.header')

    <!-- Flash Messages -->
    @if (session('success'))
        <div id="toast-success" class="fixed z-50 top-4 right-4 bg-green-100 border border-green-200 text-green-800 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-2 transition-opacity duration-300 opacity-100">
            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var toast = document.getElementById('toast-success');
                    if (toast) {
                        toast.style.opacity = '0';
                        setTimeout(function() { toast.remove(); }, 300);
                    }
                }, 3000);
            });
        </script>
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

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>
</html>
