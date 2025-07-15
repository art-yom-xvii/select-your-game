@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')
    <div class="bg-white py-6">
        <div class="container mx-auto px-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">Products</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <!-- Clear All Filters Button -->
                        <div class="mt-6 text-center">
                            <button id="clear-all-filters" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded">
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Categories</h3>
                            <button type="button" class="clear-filter text-sm text-primary hover:underline" data-filter="categories">Clear</button>
                        </div>
                        <div class="space-y-2">
                            @foreach ($categories as $category)
                                <div class="flex items-center">
                                    <input type="checkbox" id="category-{{ $category->id }}" class="filter-checkbox" data-filter="categories" value="{{ $category->id }}"
                                        @if (request('categories') && in_array($category->id, is_array(request('categories')) ? request('categories') : explode(',', request('categories')))) checked @endif
                                    >
                                    <label for="category-{{ $category->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Platforms</h3>
                            <button type="button" class="clear-filter text-sm text-primary hover:underline" data-filter="platforms">Clear</button>
                        </div>
                        <div class="space-y-2">
                            @foreach ($platforms as $platform)
                                <div class="flex items-center">
                                    <input type="checkbox" id="platform-{{ $platform->id }}" class="filter-checkbox" data-filter="platforms" value="{{ $platform->id }}"
                                        @if (request('platforms') && in_array($platform->id, is_array(request('platforms')) ? request('platforms') : explode(',', request('platforms')))) checked @endif
                                    >
                                    <label for="platform-{{ $platform->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">
                                        {{ $platform->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Product Type</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type-all" class="filter-radio" data-filter="type" value=""
                                    @if (!request('type')) checked @endif
                                >
                                <label for="type-all" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">All Products</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type-games" class="filter-radio" data-filter="type" value="games"
                                    @if (request('type') === 'games') checked @endif
                                >
                                <label for="type-games" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">Video Games</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type-merchandise" class="filter-radio" data-filter="type" value="merchandise"
                                    @if (request('type') === 'merchandise') checked @endif
                                >
                                <label for="type-merchandise" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">Merchandise</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="w-full lg:w-3/4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold mb-4 md:mb-0">
                            @if (request('type') === 'games')
                                Video Games
                            @elseif (request('type') === 'merchandise')
                                Gaming Merchandise
                            @else
                                All Products
                            @endif

                            @if (request('platform'))
                                @foreach ($platforms as $platform)
                                    @if (request('platform') === $platform->slug)
                                        for {{ $platform->name }}
                                    @endif
                                @endforeach
                            @endif

                            @if (request('category'))
                                @foreach ($categories as $category)
                                    @if (request('category') === $category->slug)
                                        in {{ $category->name }}
                                    @endif
                                @endforeach
                            @endif
                        </h2>

                        <div class="flex items-center">
                            <label for="sort" class="mr-2 text-gray-700">Sort By:</label>
                            <select id="sort" class="filter-select border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                <option value="newest" @if (request('sort') === 'newest') selected @endif>Newest</option>
                                <option value="price-asc" @if (request('sort') === 'price-asc') selected @endif>Price: Low to High</option>
                                <option value="price-desc" @if (request('sort') === 'price-desc') selected @endif>Price: High to Low</option>
                                <option value="bestselling" @if (request('sort') === 'bestselling') selected @endif>Bestselling</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($products as $product)
                            <div class="bg-white rounded-lg shadow overflow-hidden game-card-hover">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <div class="relative aspect-[3/4] bg-gray-200">
                                        @if ($product->primaryImage)
                                            <img src="{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                                        @endif

                                        @if ($product->platform && $product->product_type === 'game')
                                            <div class="absolute top-2 left-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                                    @if ($product->platform->slug === 'ps4') bg-ps4 text-white
                                                    @elseif ($product->platform->slug === 'xbox') bg-xbox text-white
                                                    @elseif ($product->platform->slug === 'switch') bg-nintendo text-white
                                                    @else bg-gray-600 text-white
                                                    @endif">
                                                    {{ $product->platform->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <div class="p-4">
                                    <h3 class="text-lg font-medium mb-1 truncate">
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-gray-900 hover:text-primary">{{ $product->name }}</a>
                                    </h3>
                                    <div class="text-gray-500 text-sm mb-2">
                                        @if ($product->publisher && $product->product_type === 'game')
                                            <span>{{ $product->publisher }}</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            @if ($product->compare_at_price && $product->compare_at_price > $product->price)
                                                <span class="text-gray-500 line-through text-sm">${{ number_format($product->compare_at_price, 2) }}</span>
                                            @endif
                                            <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                                <p class="text-gray-500">No products found matching your criteria.</p>
                                <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded">Clear Filters</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle filter changes
        const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
        const filterRadios = document.querySelectorAll('.filter-radio');
        const filterSelect = document.querySelector('.filter-select');
        const clearAllFiltersButton = document.getElementById('clear-all-filters');
        const clearFilterButtons = document.querySelectorAll('.clear-filter');

        console.log('Filter Checkboxes:', filterCheckboxes);

        const applyFilters = () => {
            const params = new URLSearchParams(window.location.search);

            // Get checkbox filters (categories, platforms)
            const selectedCategories = [];
            const selectedPlatforms = [];

            filterCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    if (checkbox.dataset.filter === 'categories') {
                        selectedCategories.push(checkbox.value);
                    } else if (checkbox.dataset.filter === 'platforms') {
                        selectedPlatforms.push(checkbox.value);
                    }
                }
            });

            // Update URL parameters for categories and platforms
            if (selectedCategories.length > 0) {
                params.set('categories', selectedCategories.join(','));
            } else {
                params.delete('categories');
            }

            if (selectedPlatforms.length > 0) {
                params.set('platforms', selectedPlatforms.join(','));
            } else {
                params.delete('platforms');
            }

            // Get radio filters (product type)
            filterRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value) {
                        params.set(radio.dataset.filter, radio.value);
                    } else {
                        params.delete(radio.dataset.filter);
                    }
                }
            });

            // Get sort value
            const sortValue = filterSelect.value;
            if (sortValue) {
                params.set('sort', sortValue);
            } else {
                params.delete('sort');
            }

            // Update URL
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            console.log('New URL:', newUrl);
            window.location.href = newUrl;
        };

        // Event listeners for checkboxes and radios
        filterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', applyFilters);
        });

        filterRadios.forEach(radio => {
            radio.addEventListener('change', applyFilters);
        });

        // Event listener for sort select
        filterSelect.addEventListener('change', applyFilters);

        // Handle clear all filters button
        clearAllFiltersButton.addEventListener('click', () => {
            const params = new URLSearchParams(window.location.search);
            params.delete('categories');
            params.delete('platforms');
            params.delete('type');
            params.delete('sort');
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        });

        // Handle individual filter section clear buttons
        clearFilterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filterType = button.dataset.filter;
                const params = new URLSearchParams(window.location.search);

                // Uncheck checkboxes or reset radio buttons based on filter type
                if (filterType === 'categories') {
                    filterCheckboxes.forEach(checkbox => {
                        if (checkbox.dataset.filter === 'categories') {
                            checkbox.checked = false;
                        }
                    });
                    params.delete('categories');
                } else if (filterType === 'platforms') {
                    filterCheckboxes.forEach(checkbox => {
                        if (checkbox.dataset.filter === 'platforms') {
                            checkbox.checked = false;
                        }
                    });
                    params.delete('platforms');
                } else if (filterType === 'type') {
                    filterRadios.forEach(radio => {
                        if (radio.dataset.filter === 'type' && radio.value === '') {
                            radio.checked = true;
                        }
                    });
                    params.delete('type');
                }

                // Update URL
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            });
        });
    });
</script>
@endpush
