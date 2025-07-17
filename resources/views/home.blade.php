@extends('layouts.app')

@section('title', 'Video Games & Gaming Merchandise')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@section('content')
    <!-- Hero Banner -->
    <section class="relative bg-cover bg-center h-[500px]" style="background-image: url('https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto px-4 h-full flex items-center relative z-10">
            <div class="max-w-xl">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-heading">Select Your Game</h1>
                <p class="text-xl text-gray-200 mb-8">Your one-stop shop for all gaming needs - from the latest video games to exclusive merchandise.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}?type=games" class="bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded text-center">Shop Games</a>
                    <a href="{{ route('products.index') }}?type=merchandise" class="bg-secondary hover:bg-secondary-dark text-white font-medium py-3 px-6 rounded text-center">Shop Merchandise</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories-section py-8">
        <div class="container mx-auto px-4 relative pb-2">
            <h2 class="text-2xl font-bold mb-6">Game Categories</h2>

            {{-- Categories --}}
            <div class="swiper categories-swiper relative">

            <!-- Categories Arrow Navigation -->
            <div class="absolute inset-0 pointer-events-none z-100 flex items-center">
                <div class="w-full flex justify-between">
                    <button class="categories-swiper-prev pointer-events-auto bg-white shadow-md rounded-full p-2 -ml-2 hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="categories-swiper-next pointer-events-auto bg-white shadow-md rounded-full p-2 -mr-2 hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                        <div class="swiper-slide">
                            <a href="{{ route('products.index') }}?type=games&categories={{ $category->id }}"
                               class="bg-white rounded-lg shadow-md p-4 text-center transition-colors group category-card min-h-20 flex items-center justify-center hover:bg-primary hover:text-white cursor-pointer">
                                <div class="category-card-content">
                                    {{ $category->name }}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.categories-swiper', {
                    slidesPerView: 2,
                    spaceBetween: 15,
                    navigation: {
                        nextEl: '.categories-swiper-next',
                        prevEl: '.categories-swiper-prev',
                    },
                    // Enable touch/swipe scrolling
                    mousewheel: true,
                    keyboard: true,
                    grabCursor: true,
                    breakpoints: {
                        640: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 25,
                        },
                        1024: {
                            slidesPerView: 6,
                            spaceBetween: 30,
                        }
                    },
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: true,
                    }
                });
            });
        </script>
    @endpush

    <!-- Featured Games -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold font-heading">Featured Games</h2>
                <a href="{{ route('products.index') }}?type=games&featured=1" class="text-primary hover:text-primary-dark font-medium">View All</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($featuredGames as $game)
                    <div class="bg-white rounded-lg shadow overflow-hidden game-card-hover">
                        <a href="{{ route('products.show', $game->slug) }}">
                            <div class="relative aspect-[3/4] bg-gray-200">
                                @if ($game->primaryImage)
                                    <img src="{{ $game->primaryImage->image_path }}" alt="{{ $game->name }}" class="absolute inset-0 w-full h-full object-cover">
                                @endif

                                @if ($game->platform)
                                    <div class="absolute top-2 left-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            @if ($game->platform->slug === 'ps4') bg-ps4 text-white
                                            @elseif ($game->platform->slug === 'xbox') bg-xbox text-white
                                            @elseif ($game->platform->slug === 'switch') bg-nintendo text-white
                                            @else bg-gray-600 text-white
                                            @endif">
                                            {{ $game->platform->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-1 truncate">
                                <a href="{{ route('products.show', $game->slug) }}" class="text-gray-900 hover:text-primary">{{ $game->name }}</a>
                            </h3>
                            <div class="text-gray-500 text-sm mb-2">
                                @if ($game->publisher)
                                    <span>{{ $game->publisher }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    @if ($game->compare_at_price && $game->compare_at_price > $game->price)
                                        <span class="text-gray-500 line-through text-sm">${{ number_format($game->compare_at_price, 2) }}</span>
                                    @endif
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($game->price, 2) }}</span>
                                </div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $game->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full w-10 h-10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No featured games available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- New Releases -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold font-heading">New Releases</h2>
                <a href="{{ route('products.index') }}?type=games&sort=newest" class="text-primary hover:text-primary-dark font-medium">View All</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse ($newReleases as $game)
                    <a href="{{ route('products.show', $game->slug) }}" class="group">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition-shadow aspect-square relative">
                            @if ($game->primaryImage)
                                <img src="{{ $game->primaryImage->image_path }}" alt="{{ $game->name }}" class="absolute inset-0 w-full h-full object-cover">
                            @endif

                            @if ($game->platform)
                                <div class="absolute bottom-2 right-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        @if ($game->platform->slug === 'ps4') bg-ps4 text-white
                                        @elseif ($game->platform->slug === 'xbox') bg-xbox text-white
                                        @elseif ($game->platform->slug === 'switch') bg-nintendo text-white
                                        @else bg-gray-600 text-white
                                        @endif">
                                        {{ $game->platform->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <h3 class="mt-2 font-medium text-gray-800 group-hover:text-primary truncate">{{ $game->name }}</h3>
                        <p class="text-primary font-bold">${{ number_format($game->price, 2) }}</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No new releases available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Merchandise -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold font-heading">Gaming Merchandise</h2>
                <a href="{{ route('products.index') }}?type=merchandise" class="text-primary hover:text-primary-dark font-medium">View All</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @forelse ($featuredMerchandise as $item)
                    <div class="bg-white rounded-lg shadow overflow-hidden game-card-hover">
                        <a href="{{ route('products.show', $item->slug) }}">
                            <div class="aspect-square bg-gray-200 relative">
                                @if ($item->primaryImage)
                                    <img src="{{ $item->primaryImage->image_path }}" alt="{{ $item->name }}" class="absolute inset-0 w-full h-full object-contain p-4">
                                @endif
                            </div>
                        </a>

                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-1 truncate">
                                <a href="{{ route('products.show', $item->slug) }}" class="text-gray-900 hover:text-primary">{{ $item->name }}</a>
                            </h3>
                            <div class="flex justify-between items-center">
                                <div>
                                    @if ($item->compare_at_price && $item->compare_at_price > $item->price)
                                        <span class="text-gray-500 line-through text-sm">${{ number_format($item->compare_at_price, 2) }}</span>
                                    @endif
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($item->price, 2) }}</span>
                                </div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full w-10 h-10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No merchandise available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
