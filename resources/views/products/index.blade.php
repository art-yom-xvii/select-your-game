@extends('layouts.app')

@section('title', 'Browse Products')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
@endpush

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Home',
                'url' => route('home'),
                'icon' => '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>',
                'active' => false,
            ],
            [
                'label' => 'Products',
                'url' => '',
                'icon' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
                'active' => true,
            ],
        ];

        // {{-- Search Form Section --}} & {{-- Product Count Section --}}
        $breadcrumbSlot = '
            <div class="w-full flex gap-2 md:gap-4 justify-center items-center">
                <div class="w-full flex justify-center mb-2 md:mb-0 rounded-lg p-2">
                    <form method="GET" action="" class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto justify-center">
                        <input
                            type="text"
                            name="search"
                            value="'.e(request('search', '')).'"
                            placeholder="Search products..."
                            class="w-full sm:w-96 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition"
                        >
                        '.collect(request()->except(['search', 'page']))->map(function($value, $key) {
                            if (is_array($value)) {
                                return collect($value)->map(function($v) use ($key) {
                                    return '<input type="hidden" name="'.$key.'[]" value="'.e($v).'">';
                                })->implode('');
                            } else {
                                return '<input type="hidden" name="'.$key.'" value="'.e($value).'">';
                            }
                        })->implode('').'                        <button type="submit" class="border border-primary text-primary bg-white hover:bg-primary hover:text-white font-bold px-6 py-2 rounded-lg transition">Search</button>
                    </form>
                </div>
                <div class="w-full flex justify-center md:justify-end rounded-lg p-2" id="product-count-container" data-total-count="'.e($products->total()).'">
                    <span class="inline-block text-gray-700 rounded px-4 py-2 text-sm font-medium" id="product-count-text">Displaying '.e($products->count()).' items of '.e($products->total()).' items</span>
                </div>
            </div>
        ';
    @endphp
    @include('partials.breadcrumb', ['items' => $breadcrumbItems, 'slot' => $breadcrumbSlot])

    <script>
                function updateProductCount(visibleCount, totalCount) {
                    document.getElementById('product-count-text').textContent =
                        `Displaying ${visibleCount} items of ${totalCount} items`;
                }

                // Example: Listen for custom events when products are updated (e.g., after filters or load more)
                document.addEventListener('products:updated', function(e) {
                    // e.detail should contain { visibleCount, totalCount }
                    if (e.detail && typeof e.detail.visibleCount !== 'undefined' && typeof e.detail.totalCount !== 'undefined') {
                        updateProductCount(e.detail.visibleCount, e.detail.totalCount);
                    }
                });

                // If you use AJAX to load more/filter products, dispatch this event after updating the product grid:
                // document.dispatchEvent(new CustomEvent('products:updated', { detail: { visibleCount: newCount, totalCount: totalCount } }));
            </script>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <!-- Clear All Filters Button -->
                        <div class="mt-6 text-center">
                            <button id="clear-all-filters" class="bg-secondary hover:bg-secondary-dark text-white py-2 px-4 rounded">
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

                    <div class="bg-white p-6 rounded shadow-sm mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Price</h3>
                            <button type="button" class="clear-filter text-sm text-primary hover:underline" data-filter="price">Clear</button>
                        </div>
                        <div class="flex flex-col items-center w-full">
                            <div id="price-slider" class="w-full mb-4"
                                 data-min="{{ $priceMin ?? 0 }}"
                                 data-max="{{ $priceMax ?? 500 }}"></div>
                            <div class="flex justify-between w-full">
                                <div>
                                    <span>$</span>
                                    <input type="number" id="price-min-input" class="border rounded px-2 py-1 w-24" min="0" max="500" value="{{ request('price_min', 0) }}">
                                </div>
                                <span class="mx-2">to</span>
                                <div>
                                    <span>$</span>
                                    <input type="number" id="price-max-input" class="border rounded px-2 py-1 w-24" min="0" max="500" value="{{ request('price_max', 500) }}">
                                </div>
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

                    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @include('products.partials.product-grid', ['products' => $products])
                    </div>

                    <!-- Load More Button -->
                    @if ($products->hasMorePages())
                        <div class="mt-8 text-center">
                            <button id="load-more-products" class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-lg cursor-pointer">
                                Load More Products
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Restore scroll position if present
        const scrollPos = sessionStorage.getItem('scrollPos');
        if (scrollPos !== null) {
            window.scrollTo(0, parseInt(scrollPos));
            sessionStorage.removeItem('scrollPos');
        }
        // Handle filter changes
        const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
        const filterRadios = document.querySelectorAll('.filter-radio');
        const filterSelect = document.querySelector('.filter-select');
        const clearAllFiltersButton = document.getElementById('clear-all-filters');
        const clearFilterButtons = document.querySelectorAll('.clear-filter');

        console.log('Filter Checkboxes:', filterCheckboxes);

        let applyFilters = () => {
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
            sessionStorage.setItem('scrollPos', window.scrollY);
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
            params.delete('category'); // Remove category slug
            params.delete('platform'); // Remove platform slug
            params.delete('type');
            params.delete('sort');
            params.delete('search');
            params.delete('price_min');
            params.delete('price_max');

            // Reset price slider and inputs to dynamic min/max
            var priceSlider = document.getElementById('price-slider');
            var priceMinInput = document.getElementById('price-min-input');
            var priceMaxInput = document.getElementById('price-max-input');
            var minPrice = parseInt(priceSlider.getAttribute('data-min')) || 0;
            var maxPrice = parseInt(priceSlider.getAttribute('data-max')) || 500;

            if (priceSlider && priceSlider.noUiSlider) {
                priceSlider.noUiSlider.set([minPrice, maxPrice]);
            }
            if (priceMinInput) priceMinInput.value = minPrice;
            if (priceMaxInput) priceMaxInput.value = maxPrice;

            sessionStorage.setItem('scrollPos', window.scrollY);
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
                } else if (filterType === 'price') {
                    const priceMin = document.getElementById('price-min-input');
                    const priceMax = document.getElementById('price-max-input');
                    priceMin.value = 0;
                    priceMax.value = 500;
                    params.delete('price_min');
                    params.delete('price_max');
                }

                // Update URL
                sessionStorage.setItem('scrollPos', window.scrollY);
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            });
        });

        // Price Range Slider
        var priceSlider = document.getElementById('price-slider');
        var priceMinInput = document.getElementById('price-min-input');
        var priceMaxInput = document.getElementById('price-max-input');
        var minPrice = parseInt(priceSlider.getAttribute('data-min')) || 0;
        var maxPrice = parseInt(priceSlider.getAttribute('data-max')) || 500;

        if (priceSlider && priceMinInput && priceMaxInput) {
            noUiSlider.create(priceSlider, {
                start: [parseInt(priceMinInput.value) || minPrice, parseInt(priceMaxInput.value) || maxPrice],
                connect: true,
                range: {
                    'min': minPrice,
                    'max': maxPrice
                },
                step: 1,
                tooltips: false,
                format: {
                    to: function (value) { return Math.round(value); },
                    from: function (value) { return Number(value); }
                }
            });

            priceSlider.noUiSlider.on('update', function(values, handle) {
                if (handle === 0) {
                    priceMinInput.value = values[0];
                } else {
                    priceMaxInput.value = values[1];
                }
            });

            priceSlider.noUiSlider.on('change', function(values) {
                const params = new URLSearchParams(window.location.search);
                params.set('price_min', values[0]);
                params.set('price_max', values[1]);
                sessionStorage.setItem('scrollPos', window.scrollY);
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            });

            priceMinInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([this.value, null]);
            });
            priceMaxInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([null, this.value]);
            });
        }

        const loadMoreButton = document.getElementById('load-more-products');

        if (loadMoreButton) {
            let currentPage = {{ $products->currentPage() }};
            const totalPages = {{ $products->lastPage() }};

            loadMoreButton.addEventListener('click', function() {
                // Prepare the current URL parameters
                const params = new URLSearchParams(window.location.search);

                // Increment page number
                currentPage++;
                params.set('page', currentPage);

                // Disable button and show loading state
                loadMoreButton.disabled = true;
                loadMoreButton.innerHTML = 'Loading...';
                loadMoreButton.classList.add('opacity-50', 'cursor-not-allowed');

                // Fetch the next page of products (expect JSON)
                fetch(`${window.location.pathname}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const productGrid = document.getElementById('product-grid');
                    if (data && data.html) {
                        // Create a temporary div to parse the HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;
                        const newProducts = tempDiv.querySelectorAll('.game-card-hover');
                        newProducts.forEach(product => {
                            product.classList.add('fade-in-product');
                            productGrid.appendChild(product);
                            // Force reflow to enable transition
                            void product.offsetWidth;
                            product.classList.add('visible');
                            // Remove the class after animation for future loads
                            setTimeout(() => product.classList.remove('fade-in-product', 'visible'), 600);
                        });
                        // Dispatch event to update product count
                        const totalCount = document.getElementById('product-count-container').dataset.totalCount;
                        document.dispatchEvent(new CustomEvent('products:updated', {
                            detail: {
                                visibleCount: productGrid.querySelectorAll('.game-card-hover').length,
                                totalCount: totalCount
                            }
                        }));
                    }
                    // Remove or update Load More button
                    if (!data || !data.has_more || !data.html || data.html.trim() === '') {
                        loadMoreButton.remove();
                        if (!data || !data.html || data.html.trim() === '') {
                            const msg = document.createElement('div');
                            msg.className = 'text-gray-500 text-center my-4';
                            msg.textContent = 'No more products found.';
                            productGrid.appendChild(msg);
                        }
                    } else {
                        loadMoreButton.disabled = false;
                        loadMoreButton.innerHTML = 'Load More Products';
                        loadMoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    loadMoreButton.disabled = false;
                    loadMoreButton.innerHTML = 'Load More Products';
                    loadMoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            });
        }
    });
</script>
@endpush
