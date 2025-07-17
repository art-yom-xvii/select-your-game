@extends('layouts.app')

@section('title', 'Checkout')

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
                'label' => 'Cart',
                'url' => route('cart.index'),
                'icon' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
                'active' => false,
            ],
            [
                'label' => 'Checkout',
                'url' => '',
                'icon' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
                'active' => true,
            ],
        ];
    @endphp
    @include('partials.breadcrumb', ['items' => $breadcrumbItems])

    <!-- Checkout Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">Checkout</h1>

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Customer Information -->
                    <div class="w-full lg:w-2/3">
                        <!-- Contact Information -->
                        <div class="bg-white rounded-lg shadow overflow-hidden p-6 mb-6">
                            <h2 class="text-xl font-bold mb-4">Contact Information</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" id="customer_name" name="customer_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" required value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="customer_email" name="customer_email" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" required value="{{ old('customer_email') }}">
                                    @error('customer_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (optional)</label>
                                <input type="tel" id="customer_phone" name="customer_phone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" value="{{ old('customer_phone') }}">
                                @error('customer_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="bg-white rounded-lg shadow overflow-hidden p-6 mb-6">
                            <h2 class="text-xl font-bold mb-4">Billing Address</h2>

                            <div class="mb-4">
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea id="billing_address" name="billing_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" required>{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="same_address" name="same_address" class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" checked>
                                    <label for="same_address" class="ml-2 block text-sm text-gray-900">
                                        Shipping address same as billing
                                    </label>
                                </div>
                            </div>

                            <div id="shipping-address-container" class="hidden">
                                <h2 class="text-xl font-bold mb-4">Shipping Address</h2>

                                <div class="mb-4">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="bg-white rounded-lg shadow overflow-hidden p-6">
                            <h2 class="text-xl font-bold mb-4">Payment Method</h2>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" id="payment_credit_card" name="payment_method" value="credit_card" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" checked>
                                    <label for="payment_credit_card" class="ml-2 block text-sm font-medium text-gray-700">
                                        Credit Card
                                    </label>
                                </div>

                                <div id="credit-card-fields" class="pl-6 space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                            <input type="text" id="card_number" name="card_number" placeholder="**** **** **** ****" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                        </div>

                                        <div>
                                            <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                                            <input type="text" id="card_name" name="card_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        <div class="col-span-1">
                                            <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                            <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                        </div>

                                        <div class="col-span-1">
                                            <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                            <input type="text" id="card_cvv" name="card_cvv" placeholder="***" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <input type="radio" id="payment_paypal" name="payment_method" value="paypal" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                    <label for="payment_paypal" class="ml-2 block text-sm font-medium text-gray-700">
                                        PayPal
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6">
                                <div class="flex items-center">
                                    <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required>
                                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                                        I agree to the <a href="{{ route('pages.terms') }}" class="text-primary hover:text-primary-dark">Terms and Conditions</a> and <a href="{{ route('pages.privacy') }}" class="text-primary hover:text-primary-dark">Privacy Policy</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-lg shadow overflow-hidden p-6">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                            <div class="divide-y divide-gray-200">
                                @foreach ($cart->items as $item)
                                    <div class="flex py-4 items-center">
                                        <div class="h-16 w-16 bg-gray-100 rounded overflow-hidden">
                                            @if ($item->product->primaryImage)
                                                <img src="{{ $item->product->primaryImage->image_path }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 pt-4 mt-4 space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($cart->total, 2) }}</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax (8%)</span>
                                    <span class="font-medium">${{ number_format($cart->total * 0.08, 2) }}</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">$5.99</span>
                                </div>

                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span>${{ number_format($cart->total + ($cart->total * 0.08) + 5.99, 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded font-bold flex items-center justify-center">
                                    Place Order
                                </button>
                                <p class="text-xs text-center text-gray-500 mt-2">
                                    By clicking "Place Order", you agree to our terms and conditions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle shipping address form
        const sameAddressCheckbox = document.getElementById('same_address');
        const shippingAddressContainer = document.getElementById('shipping-address-container');
        const shippingAddressField = document.getElementById('shipping_address');

        function toggleShippingAddress() {
            if (sameAddressCheckbox.checked) {
                shippingAddressContainer.classList.add('hidden');
                shippingAddressField.removeAttribute('required');
            } else {
                shippingAddressContainer.classList.remove('hidden');
                shippingAddressField.setAttribute('required', 'required');
            }
        }

        sameAddressCheckbox.addEventListener('change', toggleShippingAddress);
        toggleShippingAddress(); // Set initial state

        // Toggle payment method fields
        const paymentCreditCard = document.getElementById('payment_credit_card');
        const paymentPaypal = document.getElementById('payment_paypal');
        const creditCardFields = document.getElementById('credit-card-fields');

        function togglePaymentFields() {
            if (paymentCreditCard.checked) {
                creditCardFields.classList.remove('hidden');
            } else {
                creditCardFields.classList.add('hidden');
            }
        }

        paymentCreditCard.addEventListener('change', togglePaymentFields);
        paymentPaypal.addEventListener('change', togglePaymentFields);
        togglePaymentFields(); // Set initial state

        // Form validation
        const checkoutForm = document.getElementById('checkout-form');

        checkoutForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Basic validation for required fields
            const requiredFields = checkoutForm.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            // Add more validations here as needed (credit card format, email format, etc.)

            if (!isValid) {
                e.preventDefault();
                alert('Please fill out all required fields');
            }
        });
    });
</script>
@endpush
