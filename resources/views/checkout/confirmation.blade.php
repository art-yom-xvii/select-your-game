@extends('layouts.app')

@section('title', 'Order Confirmation')

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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">Order Confirmation</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Confirmation Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <div class="text-center mb-8">
                        <div class="flex justify-center">
                            <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mt-4">Thank You for Your Order!</h1>
                        <p class="text-gray-600 mt-2">Your order has been confirmed and will be shipping soon.</p>
                    </div>

                    <div class="border-t border-b border-gray-200 py-4 mb-6">
                        <div class="flex justify-between mb-2">
                            <div class="text-sm text-gray-600">Order Number:</div>
                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                        </div>
                        <div class="flex justify-between mb-2">
                            <div class="text-sm text-gray-600">Date:</div>
                            <div class="text-sm font-medium text-gray-900">{{ $order->created_at->format('F j, Y') }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-600">Total:</div>
                            <div class="text-sm font-medium text-gray-900">${{ number_format($order->total, 2) }}</div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Details</h2>

                        <div class="border rounded-md overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->product_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${{ number_format($item->price, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Subtotal</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Tax</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">${{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Shipping</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">${{ number_format($order->shipping_cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-base font-bold text-gray-900 text-right">Total</td>
                                        <td class="px-6 py-4 text-base font-bold text-gray-900 text-right">${{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 mb-2">Shipping Information</h2>
                            <address class="not-italic text-sm text-gray-600">
                                <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                                <p>{{ $order->shipping_address }}</p>
                            </address>
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-gray-900 mb-2">Payment Information</h2>
                            <p class="text-sm text-gray-600">
                                <span class="block">{{ ucfirst($order->payment_method) }}</span>
                                <span class="block">Status:
                                    @if ($order->paid_at)
                                        <span class="text-green-600 font-medium">Paid</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">Pending</span>
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="text-center pt-6">
                        <p class="text-sm text-gray-600 mb-4">We've sent a confirmation email to <strong>{{ $order->customer_email }}</strong></p>

                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('home') }}" class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded font-medium">
                                Continue Shopping
                            </a>

                            <button type="button" onclick="window.print()" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-6 rounded font-medium flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Receipt
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">What's Next?</h2>

                    <ol class="relative border-l border-gray-200 ml-3">
                        <li class="mb-6 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-primary rounded-full -left-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <h3 class="font-medium text-gray-900">Order Confirmed</h3>
                            <p class="text-sm text-gray-600">We've received your order and payment.</p>
                        </li>
                        <li class="mb-6 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3">
                                <span class="text-xs font-medium text-gray-700">2</span>
                            </span>
                            <h3 class="font-medium text-gray-900">Processing</h3>
                            <p class="text-sm text-gray-600">We're preparing your order for shipment.</p>
                        </li>
                        <li class="mb-6 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3">
                                <span class="text-xs font-medium text-gray-700">3</span>
                            </span>
                            <h3 class="font-medium text-gray-900">Shipped</h3>
                            <p class="text-sm text-gray-600">Your order is on the way to you.</p>
                        </li>
                        <li class="ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3">
                                <span class="text-xs font-medium text-gray-700">4</span>
                            </span>
                            <h3 class="font-medium text-gray-900">Delivered</h3>
                            <p class="text-sm text-gray-600">Your order has been delivered.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection
