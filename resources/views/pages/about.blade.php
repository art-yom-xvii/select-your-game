@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <!-- Hero -->
    <div class="bg-primary py-16 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-4 font-heading">About Us</h1>
            <p class="text-xl text-white opacity-80 max-w-3xl mx-auto">Your trusted destination for all gaming needs since 2023.</p>
        </div>
    </div>

    <!-- Our Story -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold mb-6 text-center font-heading">Our Story</h2>
                <div class="prose prose-lg mx-auto">
                    <p>Select Your Game was founded in 2023 by a group of passionate gamers who wanted to create a one-stop destination for all gaming needs. What started as a small online store has now grown into a comprehensive e-commerce platform offering a wide range of video games, accessories, and gaming memorabilia.</p>

                    <p>Our mission is to provide gamers with easy access to their favorite games across multiple platforms, alongside high-quality merchandise that celebrates gaming culture. We believe that gaming is more than just a hobby – it's a community, a passion, and for many, a way of life.</p>

                    <p>At Select Your Game, we carefully curate our collection to ensure we offer only the best products for our customers. From the latest AAA titles to indie gems, from limited edition collectibles to everyday gaming accessories, we strive to be your one-stop gaming shop.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center font-heading">Our Values</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Quality First</h3>
                    <p class="text-gray-600">We carefully select every product in our inventory to ensure we offer only the best to our customers.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Community Driven</h3>
                    <p class="text-gray-600">We listen to our community and continuously adapt our offerings based on gamer feedback and preferences.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Trust & Security</h3>
                    <p class="text-gray-600">We prioritize customer security with safe transactions and transparent business practices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center font-heading">Meet Our Team</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="h-48 w-48 mx-auto rounded-full overflow-hidden mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=256&h=256&q=80" alt="John Doe" class="h-full w-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">John Doe</h3>
                    <p class="text-gray-600">Founder & CEO</p>
                </div>

                <div class="text-center">
                    <div class="h-48 w-48 mx-auto rounded-full overflow-hidden mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=256&h=256&q=80" alt="Jane Smith" class="h-full w-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">Jane Smith</h3>
                    <p class="text-gray-600">Head of Operations</p>
                </div>

                <div class="text-center">
                    <div class="h-48 w-48 mx-auto rounded-full overflow-hidden mb-4">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=256&h=256&q=80" alt="Mike Johnson" class="h-full w-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">Mike Johnson</h3>
                    <p class="text-gray-600">Lead Game Curator</p>
                </div>

                <div class="text-center">
                    <div class="h-48 w-48 mx-auto rounded-full overflow-hidden mb-4">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=256&h=256&q=80" alt="Sarah Williams" class="h-full w-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">Sarah Williams</h3>
                    <p class="text-gray-600">Customer Experience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center font-heading">Why Choose Us</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Wide Selection</h3>
                        <p class="text-gray-300">From the latest AAA titles to hard-to-find classics, we offer games for all major platforms.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Fast Shipping</h3>
                        <p class="text-gray-300">Most orders ship within 24 hours, getting games and merchandise to you as quickly as possible.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Secure Shopping</h3>
                        <p class="text-gray-300">Shop with confidence knowing your personal and payment information is always protected.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Expert Support</h3>
                        <p class="text-gray-300">Our customer service team consists of gamers who understand your needs and questions.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Hassle-Free Returns</h3>
                        <p class="text-gray-300">Not satisfied? Our 30-day return policy makes it easy to return unused items.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Best Price Guarantee</h3>
                        <p class="text-gray-300">We offer competitive pricing and regular sales to ensure you get the best value.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-secondary">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6 font-heading">Ready to Start Shopping?</h2>
            <p class="text-xl text-white opacity-90 mb-8 max-w-2xl mx-auto">Explore our collection of games and merchandise today and find your next favorite title.</p>
            <a href="{{ route('products.index') }}" class="bg-white hover:bg-gray-100 text-secondary font-bold py-3 px-8 rounded-lg inline-block">Browse Products</a>
        </div>
    </section>
@endsection
