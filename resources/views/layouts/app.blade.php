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
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-primary">Select<span class="text-secondary">Your</span>Game</span>
                </a>

                <!-- Main Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('products.index') }}?type=games" class="text-gray-700 hover:text-primary font-medium">Video Games</a>
                    <a href="{{ route('products.index') }}?type=merchandise" class="text-gray-700 hover:text-primary font-medium">Merchandise</a>
                    <a href="{{ route('pages.platforms') }}" class="text-gray-700 hover:text-primary font-medium">Platforms</a>
                    <a href="{{ route('pages.about') }}" class="text-gray-700 hover:text-primary font-medium">About Us</a>
                    <a href="{{ route('pages.contact') }}" class="text-gray-700 hover:text-primary font-medium">Contact</a>
                </nav>

                <!-- User & Cart -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="relative p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-counter" class="absolute -top-1 -right-1 bg-secondary text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">0</span>
                    </a>

                    @auth
                        <a href="{{ route('profile') }}" class="text-gray-700 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-primary px-3 py-2 font-medium">Sign In</a>
                        <a href="/register" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded font-medium">Register</a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" class="lg:hidden text-gray-700 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden lg:hidden py-4 space-y-2">
                <a href="{{ route('products.index') }}?type=games" class="block text-gray-700 hover:text-primary font-medium py-2">Video Games</a>
                <a href="{{ route('products.index') }}?type=merchandise" class="block text-gray-700 hover:text-primary font-medium py-2">Merchandise</a>
                <a href="{{ route('pages.platforms') }}" class="block text-gray-700 hover:text-primary font-medium py-2">Platforms</a>
                <a href="{{ route('pages.about') }}" class="block text-gray-700 hover:text-primary font-medium py-2">About Us</a>
                <a href="{{ route('pages.contact') }}" class="block text-gray-700 hover:text-primary font-medium py-2">Contact</a>
            </div>
        </div>
    </header>

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

    <!-- Footer -->
    <!-- Newsletter -->
    <section class="py-16 bg-primary">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4 font-heading">Join Our Newsletter</h2>
            <p class="text-lg text-white opacity-80 mb-8 max-w-2xl mx-auto">Subscribe to receive updates on new releases, exclusive deals, and gaming news!</p>
            <form class="max-w-md mx-auto flex">
                <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-l focus:outline-none focus:ring-2 focus:ring-secondary">
                <button type="submit" class="bg-secondary hover:bg-secondary-dark text-white font-medium px-6 py-3 rounded-r">Subscribe</button>
            </form>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Select Your Game</h3>
                    <p class="text-gray-400 mb-4">Your one-stop shop for all gaming needs - from the latest video games to exclusive merchandise.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}?type=games&platform=ps4" class="text-gray-400 hover:text-white">PS4 Games</a></li>
                        <li><a href="{{ route('products.index') }}?type=games&platform=xbox" class="text-gray-400 hover:text-white">Xbox Games</a></li>
                        <li><a href="{{ route('products.index') }}?type=games&platform=switch" class="text-gray-400 hover:text-white">Nintendo Switch Games</a></li>
                        <li><a href="{{ route('products.index') }}?type=merchandise" class="text-gray-400 hover:text-white">Gaming Merchandise</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Information</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-gray-400 hover:text-white">Contact Us</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="text-gray-400 hover:text-white">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter to receive news and exclusive offers.</p>
                    <form action="#" method="POST" class="flex">
                        <input type="email" name="email" placeholder="Your email" required class="flex-grow px-4 py-2 rounded-l text-gray-900">
                        <button type="submit" class="bg-primary hover:bg-primary-dark px-4 py-2 rounded-r">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Select Your Game. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
