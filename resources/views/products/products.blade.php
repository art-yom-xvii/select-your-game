@extends('layouts.app')

@section('title', 'Browse Products')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('css/product-filters.css') }}">
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
                {{-- ===================== FILTERS SIDEBAR ===================== --}}
                <div class="w-full lg:w-1/4">
                    {{-- ========== Clear All Filters Button ========== --}}
                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <!-- Clear All Filters Button -->
                        <div class="mt-6 text-center">
                            <button id="clear-all-filters" class="bg-secondary hover:bg-secondary-dark text-white py-2 px-4 rounded">
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    {{-- ========== Product Type Filter ========== --}}
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

                {{-- ========== Platforms Filter ========== --}}
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

                    {{-- ========== Categories Filter ========== --}}
                    <div class="bg-white p-6 rounded shadow-sm mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <button type="button" class="categories-section-toggle mr-2 text-gray-500 hover:text-primary transition-colors" data-section="categories">
                                    <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <h3 class="text-lg font-bold">Categories</h3>
                            </div>
                            <button type="button" class="clear-filter text-sm text-primary hover:underline" data-filter="categories">Clear</button>
                        </div>
                        <div class="categories-content space-y-2">
                            @php
                                $selectedCategoryIds = collect(request('categories', []));
                                if (is_string($selectedCategoryIds)) {
                                    $selectedCategoryIds = collect(explode(',', $selectedCategoryIds));
                                }
                                $sortedCategories = $categories->sortByDesc(function($cat) use ($selectedCategoryIds) {
                                    return $selectedCategoryIds->contains($cat->id) ? 1 : 0;
                                })->values();
                            @endphp
                            @foreach ($sortedCategories->take(3) as $category)
                                <div class="category-group" data-category-id="{{ $category->id }}" data-index="{{ $loop->index }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <button type="button" class="category-toggle mr-2 text-gray-500 hover:text-primary transition-colors" data-category-id="{{ $category->id }}">
                                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                            <input type="checkbox" id="category-{{ $category->id }}" class="filter-checkbox" data-filter="categories" value="{{ $category->id }}"
                                                @if (request('categories') && in_array($category->id, is_array(request('categories')) ? request('categories') : explode(',', request('categories')))) checked @endif
                                            >
                                            <label for="category-{{ $category->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $category->total_products_count }}</span>
                                    </div>

                                    @if ($category->children->count() > 0)
                                        <div class="category-children ml-6 mt-2 hidden" id="children-{{ $category->id }}">
                                            @foreach ($category->children as $child)
                                                <div class="flex items-center justify-between py-1">
                                                    <div class="flex items-center">
                                                        <input type="checkbox" id="category-{{ $child->id }}" class="filter-checkbox" data-filter="categories" value="{{ $child->id }}"
                                                            @if (request('categories') && in_array($child->id, is_array(request('categories')) ? request('categories') : explode(',', request('categories')))) checked @endif
                                                        >
                                                        <label for="category-{{ $child->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer text-sm">
                                                            {{ $child->name }}
                                                        </label>
                                                    </div>
                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $child->products_count }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="extra-categories hidden">
                                @foreach ($sortedCategories->slice(3) as $category)
                                    <div class="category-group" data-category-id="{{ $category->id }}" data-index="{{ $loop->index + 3 }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <button type="button" class="category-toggle mr-2 text-gray-500 hover:text-primary transition-colors" data-category-id="{{ $category->id }}">
                                                    <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                                <input type="checkbox" id="category-{{ $category->id }}" class="filter-checkbox" data-filter="categories" value="{{ $category->id }}"
                                                    @if (request('categories') && in_array($category->id, is_array(request('categories')) ? request('categories') : explode(',', request('categories')))) checked @endif
                                                >
                                                <label for="category-{{ $category->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $category->total_products_count }}</span>
                                        </div>

                                        @if ($category->children->count() > 0)
                                            <div class="category-children ml-6 mt-2 hidden" id="children-{{ $category->id }}">
                                                @foreach ($category->children as $child)
                                                    <div class="flex items-center justify-between py-1">
                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="category-{{ $child->id }}" class="filter-checkbox" data-filter="categories" value="{{ $child->id }}"
                                                                @if (request('categories') && in_array($child->id, is_array(request('categories')) ? request('categories') : explode(',', request('categories')))) checked @endif
                                                            >
                                                            <label for="category-{{ $child->id }}" class="ml-2 text-gray-700 hover:text-primary cursor-pointer text-sm">
                                                                {{ $child->name }}
                                                            </label>
                                                        </div>
                                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $child->products_count }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if ($categories->count() > 3)
                                <button type="button" class="show-more-categories-btn text-primary hover:underline mt-2 text-sm">Show more</button>
                                <button type="button" class="show-less-categories-btn text-primary hover:underline mt-2 text-sm hidden">Show less</button>
                            @endif
                        </div>
                    </div>

                    {{-- ========== Price Filter ========== --}}
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
                {{-- ===================== END FILTERS SIDEBAR ===================== --}}

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
                            <button id="load-more-products" class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-lg cursor-pointer" data-current-page="{{ $products->currentPage() }}" data-total-pages="{{ $products->lastPage() }}">
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
    @vite(['resources/js/product-filters.js'])
</script>
@endpush
