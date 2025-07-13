@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <!-- Breadcrumb -->
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
                            <span class="ml-1 text-gray-500 md:ml-2">Shopping Cart</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Cart Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

            @if ($items->count() > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Cart Items -->
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-16 flex-shrink-0 bg-gray-100 rounded overflow-hidden">
                                                        @if ($item->product->primaryImage)
                                                            <img src="{{ $item->product->primaryImage->image_path }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-base font-medium text-gray-900 hover:text-primary">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        @if ($item->product->platform && $item->product->product_type === 'game')
                                                            <div class="text-sm text-gray-500">
                                                                Platform: {{ $item->product->platform->name }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">${{ number_format($item->price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="quantity" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('products.index') }}" class="flex items-center text-primary hover:text-primary-dark font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Continue Shopping
                            </a>

                            <form action="{{ url('/cart/clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Clear Cart</button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-lg shadow overflow-hidden p-6">
                            <h2 class="text-lg font-bold mb-6">Order Summary</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($cart->total, 2) }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Estimated Tax</span>
                                    <span class="font-medium">${{ number_format($cart->total * 0.08, 2) }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">$5.99</span>
                                </div>

                                <div class="border-t pt-4">
                                    <div class="flex justify-between font-bold">
                                        <span>Total</span>
                                        <span>${{ number_format($cart->total + ($cart->total * 0.08) + 5.99, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('checkout.index') }}" class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded font-bold flex items-center justify-center">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('products.index') }}" class="bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded font-medium">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
