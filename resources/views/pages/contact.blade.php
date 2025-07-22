@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Combined Hero + Contact Form Section -->
    <section class="relative min-h-[600px] flex items-center justify-center py-16 md:py-24 bg-primary overflow-hidden rounded-b-2xl shadow-xl mb-12">
        <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80" alt="Gaming" class="absolute inset-0 w-full h-full object-cover opacity-30 pointer-events-none select-none rounded-b-2xl" loading="lazy">
        <div class="relative z-10 container mx-auto px-4 flex flex-col md:flex-row items-center md:items-stretch justify-center gap-8">
            <div class="flex-1 flex flex-col justify-center md:justify-start md:pr-8 max-w-xl text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-heading drop-shadow-lg text-balance">Contact Us</h1>
                <p class="text-xl text-white opacity-90 max-w-2xl drop-shadow text-balance mb-8">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                <div class="flex flex-col justify-center md:justify-start gap-4">
                    @foreach ([
                        ['Facebook', 'facebook.com/SelectYourGame', 'https://facebook.com/SelectYourGame', 'bg-blue-600 hover:bg-blue-700', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>'],
                        ['Instagram', 'instagram.com/SelectYourGame', 'https://instagram.com/SelectYourGame', 'bg-pink-600 hover:bg-pink-700', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>'],
                        ['Twitter', 'twitter.com/SelectYourGame', 'https://twitter.com/SelectYourGame', 'bg-blue-400 hover:bg-blue-500', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>'],
                        ['YouTube', 'youtube.com/SelectYourGame', 'https://youtube.com/SelectYourGame', 'bg-red-600 hover:bg-red-700', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>'],
                        ['Discord', 'discord.gg/SelectYourGame', 'https://discord.gg/SelectYourGame', 'bg-indigo-600 hover:bg-indigo-700', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276c-.598.3428-1.2205.6447-1.8733.8923a.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.4189 0 1.3333-.9555 2.419-2.1569 2.419zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.4189 0 1.3333-.946 2.419-2.1568 2.419z"/></svg>'],
                        ['TikTok', 'tiktok.com/@SelectYourGame', 'https://tiktok.com/@SelectYourGame', 'bg-black hover:bg-gray-800', '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.75 2v14.25a2.25 2.25 0 11-2.25-2.25h.75V12h-.75a4.5 4.5 0 104.5 4.5V7.5a5.25 5.25 0 005.25 5.25V9.75A3.75 3.75 0 0116.5 6V2h-3.75z"/></svg>'],
                    ] as [$name, $handle, $url, $bg, $svg])
                    <div class="flex items-center gap-2  rounded-xl px-4 py-2 transition">
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="{{ $bg }} text-white h-10 w-10 rounded-full flex items-center justify-center cursor-pointer transition game-card-hover">
                            <span class="sr-only">{{ $name }}</span>
                            {!! $svg !!}
                        </a>
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="text-sm text-white text-gray-700 break-words hover:underline cursor-pointer transition">{{ $handle }}</a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="flex-1 max-w-lg w-full">
                <div class="bg-white/90 p-0 md:p-0 rounded-2xl shadow-2xl backdrop-blur border border-gray-100 overflow-hidden relative">
                    <!-- Accent Bar -->
                    <div class="h-2 w-full bg-gradient-to-r from-primary to-secondary"></div>
                    <div class="p-8 md:p-10">
                        <h2 class="text-2xl font-bold mb-6 font-heading text-primary text-center">Send Us a Message</h2>
                        @if (session('success'))
                            {{-- Removed duplicate success message, now handled by toast in layout --}}
                        @endif
                        <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-primary">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </span>
                                        <input type="text" id="name" name="name" class="pl-10 border border-gray-200 bg-gray-50 rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition placeholder-gray-400" value="{{ old('name') }}" placeholder="Enter your name" required>
                                    </div>
                                    @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-primary">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-8 0v-1" /></svg>
                                        </span>
                                        <input type="email" id="email" name="email" class="pl-10 border border-gray-200 bg-gray-50 rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition placeholder-gray-400" value="{{ old('email') }}" placeholder="you@email.com" required>
                                    </div>
                                    @error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-primary">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        </span>
                                        <input type="text" id="subject" name="subject" class="pl-10 border border-gray-200 bg-gray-50 rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition placeholder-gray-400" value="{{ old('subject') }}" placeholder="Subject" required>
                                    </div>
                                    @error('subject')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-4 text-primary">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 14h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    </span>
                                    <textarea id="message" name="message" rows="6" class="pl-10 border border-gray-200 bg-gray-50 rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition placeholder-gray-400" placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                                </div>
                                @error('message')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition cursor-pointer shadow game-card-hover">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Card below form on mobile -->
    <div class="mt-16 flex flex-col items-center justify-center">
        <div class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 font-heading text-primary text-center">Our Information</h2>
            <div class="flex flex-col md:flex-row md:gap-8 gap-6 justify-center items-center">
                <div class="flex items-center md:items-start gap-4 flex-1 min-w-[220px]">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1 font-heading">Address</h3>
                        <p class="text-gray-600">
                            123 Gaming Street<br>
                            San Francisco, CA 94107<br>
                            United States
                        </p>
                    </div>
                </div>
                <div class="flex items-center md:items-start gap-4 flex-1 min-w-[220px]">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1 font-heading">Email</h3>
                        <p class="text-gray-600">
                            <a href="mailto:info@selectyourgame.com" class="text-primary hover:underline cursor-pointer transition">info@selectyourgame.com</a><br>
                            <a href="mailto:support@selectyourgame.com" class="text-primary hover:underline cursor-pointer transition">support@selectyourgame.com</a>
                        </p>
                    </div>
                </div>
                <div class="flex items-center md:items-start gap-4 flex-1 min-w-[220px]">
                    <div class="bg-primary h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1 font-heading">Phone</h3>
                        <p class="text-gray-600">
                            <a href="tel:+14155550123" class="text-primary hover:underline cursor-pointer transition">+1 (415) 555-0123</a><br>
                            <span class="text-sm">Monday to Friday, 9am to 6pm PST</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map -->
    <div class="bg-gray-100 py-12 rounded-2xl shadow-inner my-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-center font-heading text-primary">Our Location</h2>
            <div class="h-96 bg-gray-300 rounded-lg overflow-hidden shadow-lg border border-gray-200">
                <iframe
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0; min-height: 100%; min-width: 100%;"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=-122.4014%2C37.7785%2C-122.3914%2C37.7885&amp;layer=mapnik&amp;marker=37.7835%2C-122.3964"
                    allowfullscreen
                    aria-hidden="false"
                    tabindex="0"
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-center font-heading text-primary">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto">
                <div class="mb-6 bg-white p-6 rounded-xl shadow border border-gray-100">
                    <h3 class="text-lg font-bold mb-2 font-heading">What are your business hours?</h3>
                    <p class="text-gray-600">Our online store is available 24/7. Our customer service team is available Monday to Friday from 9am to 6pm PST.</p>
                </div>
                <div class="mb-6 bg-white p-6 rounded-xl shadow border border-gray-100">
                    <h3 class="text-lg font-bold mb-2 font-heading">How long does shipping take?</h3>
                    <p class="text-gray-600">Most orders ship within 24 hours. Standard shipping typically takes 3-5 business days, while express shipping is 1-2 business days.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                    <h3 class="text-lg font-bold mb-2 font-heading">Do you ship internationally?</h3>
                    <p class="text-gray-600">Yes, we ship to most countries worldwide. International shipping times vary by location, typically ranging from 7-14 business days.</p>
                </div>
                <div class="mt-8 text-center">
                    <a href="{{ route('pages.faq') }}" class="text-primary hover:text-primary-dark font-medium transition">View all FAQs →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
