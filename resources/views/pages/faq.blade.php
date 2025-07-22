@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <!-- Hero -->
    <div class="bg-primary py-16 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-4 font-heading">Frequently Asked Questions</h1>
            <p class="text-xl text-white opacity-80 max-w-3xl mx-auto">Find answers to the most common questions about our products and services.</p>
        </div>
    </div>

    <!-- FAQ Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Categories Nav -->
            <div class="mb-12">
                <ul class="flex flex-wrap justify-center gap-4">
                    <li>
                        <a href="#general" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full inline-block text-gray-800 font-medium">General</a>
                    </li>
                    <li>
                        <a href="#orders" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full inline-block text-gray-800 font-medium">Orders & Shipping</a>
                    </li>
                    <li>
                        <a href="#products" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full inline-block text-gray-800 font-medium">Products</a>
                    </li>
                    <li>
                        <a href="#returns" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full inline-block text-gray-800 font-medium">Returns & Refunds</a>
                    </li>
                    <li>
                        <a href="#account" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full inline-block text-gray-800 font-medium">Account & Privacy</a>
                    </li>
                </ul>
            </div>

            <div class="max-w-3xl mx-auto">
                <!-- General FAQs -->
                <div id="general" class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 font-heading">General Questions</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2">What is Select Your Game?</h3>
                            <div class="text-gray-600">
                                <p>Select Your Game is an e-commerce platform specializing in video games for PS4, Xbox, and Nintendo Switch, as well as gaming-related merchandise. We strive to be your one-stop shop for all gaming needs.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How can I contact customer support?</h3>
                            <div class="text-gray-600">
                                <p>You can reach our customer support team through:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li>Email: support@selectyourgame.com</li>
                                    <li>Phone: +1 (415) 555-0123 (Monday to Friday, 9am to 6pm PST)</li>
                                    <li>Contact form on our <a href="{{ route('pages.contact') }}" class="text-primary hover:underline">Contact page</a></li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">What are your business hours?</h3>
                            <div class="text-gray-600">
                                <p>Our online store is available 24/7 for shopping. Our customer service team is available Monday to Friday from 9am to 6pm PST.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders & Shipping FAQs -->
                <div id="orders" class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 font-heading">Orders & Shipping</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2">How do I place an order?</h3>
                            <div class="text-gray-600">
                                <p>Placing an order is easy:</p>
                                <ol class="list-decimal pl-5 mt-2">
                                    <li>Browse our products and add items to your cart</li>
                                    <li>Click on the cart icon to review your items</li>
                                    <li>Click "Proceed to Checkout"</li>
                                    <li>Fill in your shipping and payment information</li>
                                    <li>Review your order and click "Place Order"</li>
                                </ol>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How long does shipping take?</h3>
                            <div class="text-gray-600">
                                <p>Most orders ship within 24 hours. Delivery times depend on your shipping method:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li>Standard Shipping: 3-5 business days</li>
                                    <li>Express Shipping: 1-2 business days</li>
                                    <li>International Shipping: 7-14 business days</li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Do you ship internationally?</h3>
                            <div class="text-gray-600">
                                <p>Yes, we ship to most countries worldwide. International shipping times vary by location, typically ranging from 7-14 business days. Please note that international orders may be subject to customs duties and taxes, which are the responsibility of the recipient.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How can I track my order?</h3>
                            <div class="text-gray-600">
                                <p>Once your order ships, you'll receive an email with tracking information. You can also view your order status and tracking information in your account under "Order History".</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">What payment methods do you accept?</h3>
                            <div class="text-gray-600">
                                <p>We accept the following payment methods:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li>Credit/Debit Cards (Visa, Mastercard, American Express)</li>
                                    <li>PayPal</li>
                                    <li>Apple Pay</li>
                                    <li>Google Pay</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products FAQs -->
                <div id="products" class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 font-heading">Products</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2">Are your games new or used?</h3>
                            <div class="text-gray-600">
                                <p>Unless explicitly stated as "pre-owned" or "refurbished" in the product description, all our games are brand new, factory sealed.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Do digital game codes have an expiration date?</h3>
                            <div class="text-gray-600">
                                <p>Digital codes sold on our site typically don't have expiration dates. However, promotional or bonus content codes might have expiration dates, which will be clearly mentioned in the product description.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Are your products region-locked?</h3>
                            <div class="text-gray-600">
                                <p>Region information is clearly displayed on each product page. Most physical games for PlayStation and Nintendo Switch are region-locked, while Xbox games are generally region-free. Digital codes are typically restricted to specific regions' stores (e.g., US PlayStation Store, UK Xbox Store).</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Do you sell pre-order or upcoming games?</h3>
                            <div class="text-gray-600">
                                <p>Yes, we offer pre-orders for upcoming games. Pre-ordered items will ship on or slightly before the release date to arrive at your doorstep as close to the release date as possible.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns & Refunds FAQs -->
                <div id="returns" class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 font-heading">Returns & Refunds</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2">What is your return policy?</h3>
                            <div class="text-gray-600">
                                <p>We offer a 30-day return policy for most products. Items must be in their original condition, unopened, and with all original packaging to be eligible for a return.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How do I return an item?</h3>
                            <div class="text-gray-600">
                                <p>To return an item:</p>
                                <ol class="list-decimal pl-5 mt-2">
                                    <li>Log into your account and go to "Order History"</li>
                                    <li>Select the order containing the item you wish to return</li>
                                    <li>Click "Return Item" and follow the prompts</li>
                                    <li>Print the return label and securely package the item</li>
                                    <li>Drop off the package at your nearest shipping carrier</li>
                                </ol>
                                <p class="mt-2">Alternatively, you can contact our customer support team for assistance with returns.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">When will I receive my refund?</h3>
                            <div class="text-gray-600">
                                <p>After we receive and inspect the returned item, your refund will be processed within 3-5 business days. Depending on your payment method and bank, it may take an additional 5-10 business days for the refund to appear in your account.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Can I return digital products?</h3>
                            <div class="text-gray-600">
                                <p>Due to the nature of digital products, we cannot accept returns for digital game codes, downloadable content, or in-game currency that has been delivered or redeemed. If you haven't received or redeemed your digital code, please contact our customer support.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account & Privacy FAQs -->
                <div id="account" class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 pb-2 border-b border-gray-200 font-heading">Account & Privacy</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2">Do I need an account to shop?</h3>
                            <div class="text-gray-600">
                                <p>While you can browse products without an account, creating an account is required to make a purchase. Creating an account allows you to track orders, save your shipping information, and receive updates on orders.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How do I create an account?</h3>
                            <div class="text-gray-600">
                                <p>To create an account, click on "Sign In" in the top-right corner of our website, then select "Register". Fill in your information and create a password. You can also create an account during the checkout process.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">How secure is my personal information?</h3>
                            <div class="text-gray-600">
                                <p>We take data security very seriously. Our website uses SSL encryption to protect your personal information during transmission. We do not store full credit card details on our servers. For more information, please refer to our <a href="{{ route('pages.privacy') }}" class="text-primary hover:underline">Privacy Policy</a>.</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-2">Can I delete my account?</h3>
                            <div class="text-gray-600">
                                <p>Yes, you can request account deletion by contacting our customer support. Please note that some information may be retained for legal and business purposes, as outlined in our Privacy Policy.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Have Questions -->
                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <h2 class="text-xl font-bold mb-4">Still Have Questions?</h2>
                    <p class="text-gray-600 mb-6">Can't find what you're looking for? Our customer support team is here to help!</p>
                    <a href="{{ route('pages.contact') }}" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite(['resources/js/faq.js'])
@endpush
