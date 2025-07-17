<header class="bg-white shadow-sm sticky top-0 z-50">
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
