@extends('layouts.app')

@section('title', $product->name)

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
                'url' => route('products.index'),
                'icon' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
                'active' => false,
            ],
            [
                'label' => $product->name,
                'url' => '',
                'icon' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
                'active' => true,
            ],
        ];
    @endphp
    @include('partials.breadcrumb', ['items' => $breadcrumbItems])

    <!-- Product Detail -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Product Images -->
                <div class="w-full lg:w-1/2">
                    <div class="relative mb-4 aspect-[4/3] bg-gray-100 rounded overflow-hidden">
                        @if ($product->images->isNotEmpty())
                            <img id="mainImage" src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        @if ($product->platform && $product->product_type === 'game')
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white"
                                    style="background-color: @if ($product->platform->slug === 'playstation-4') var(--color-ps4)
                                    @elseif ($product->platform->slug === 'xbox-one') var(--color-xbox)
                                    @elseif ($product->platform->slug === 'nintendo-switch') var(--color-nintendo)
                                    @else #6b7280
                                    @endif;">
                                    {{ $product->platform->name }}
                                </span>
                            </div>
                        @endif
                    </div>

                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach ($product->images as $image)
                                <button class="thumbnail-btn aspect-square bg-gray-100 rounded overflow-hidden focus:outline-none focus:ring-2 focus:ring-primary" data-image="{{ $image->image_path }}">
                                    <img src="{{ $image->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="w-full lg:w-1/2">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

                    <!-- Product Meta -->
                    <div class="mb-4 text-gray-600">
                        @if ($product->product_type === 'game')
                            @if ($product->publisher)
                                <p>Publisher: {{ $product->publisher }}</p>
                            @endif
                            @if ($product->developer)
                                <p>Developer: {{ $product->developer }}</p>
                            @endif
                            @if ($product->release_date)
                                <p>Released: {{ $product->release_date->format('F j, Y') }}</p>
                            @endif
                            @if ($product->esrb_rating)
                                <p>Rating: {{ $product->esrb_rating }}</p>
                            @endif
                        @else
                            @if ($product->material)
                                <p>Material: {{ $product->material }}</p>
                            @endif
                            @if ($product->dimensions)
                                <p>Dimensions: {{ $product->dimensions }}</p>
                            @endif
                        @endif
                    </div>

                    <!-- Categories -->
                    <div class="mb-4 flex flex-wrap gap-2">
                        @foreach ($product->categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if ($product->compare_at_price && $product->compare_at_price > $product->price)
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-gray-500 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    {{ round((1 - $product->price / $product->compare_at_price) * 100) }}% OFF
                                </span>
                            </div>
                        @endif
                        <div class="text-3xl font-bold">${{ number_format($product->price, 2) }}</div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if ($product->stock > 0)
                            <div class="text-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                In Stock ({{ $product->stock }} available)
                            </div>
                        @else
                            <div class="text-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Out of Stock
                            </div>
                        @endif
                    </div>

                    <!-- Add to Cart -->
                    <form action="{{ route('cart.store') }}" method="POST" class="mb-8">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center mb-4">
                            <label for="quantity" class="mr-4">Quantity:</label>
                            <div class="flex">
                                <button type="button" class="quantity-btn minus bg-gray-200 px-3 py-2 rounded-l">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" class="w-16 text-center border-gray-200 focus:border-primary focus:ring-primary">
                                <button type="button" class="quantity-btn plus bg-gray-200 px-3 py-2 rounded-r">+</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded font-bold flex items-center justify-center" @if ($product->stock <= 0) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </form>

                    <!-- Product Description -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">Description</h3>
                        <div class="prose max-w-none">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-2xl font-bold mb-6">You Might Also Like</h2>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="bg-white rounded-lg shadow overflow-hidden game-card-hover">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                    <div class="aspect-[3/4] bg-gray-100 relative">
                                        @if ($relatedProduct->primaryImage)
                                            <img src="{{ $relatedProduct->primaryImage->image_path }}" alt="{{ $relatedProduct->name }}" class="absolute inset-0 w-full h-full object-cover">
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <h3 class="text-lg font-medium mb-2 truncate">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-gray-900 hover:text-primary">{{ $relatedProduct->name }}</a>
                                    </h3>
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($relatedProduct->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    @vite(['resources/js/product-details.js'])
@endpush
