@extends('layouts.app')

@section('title', 'Gaming Platforms')

@section('content')
    <!-- Hero -->
    <div class="bg-primary py-16 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-4 font-heading">Gaming Platforms</h1>
            <p class="text-xl text-white opacity-80 max-w-3xl mx-auto">Explore our collection of games for PlayStation 4, Xbox, and Nintendo Switch.</p>
        </div>
    </div>

    <!-- Platforms Overview -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- PlayStation 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-ps4 h-3"></div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_logo.svg" alt="PlayStation Logo" class="h-12">
                            <h2 class="text-2xl font-bold ml-3">PlayStation 4</h2>
                        </div>

                        <p class="text-gray-600 mb-6">Experience stunning graphics and immersive gameplay with PlayStation 4. From action-packed exclusives to multi-platform favorites, we have a wide selection of games for Sony's popular console.</p>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Popular PS4 Games:</h3>
                            <ul class="list-disc pl-5 text-gray-600">
                                <li>God of War</li>
                                <li>The Last of Us Part II</li>
                                <li>Spider-Man</li>
                                <li>Horizon Zero Dawn</li>
                                <li>Ghost of Tsushima</li>
                            </ul>
                        </div>

                        <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="bg-ps4 hover:bg-blue-700 text-white py-2 px-4 rounded font-medium inline-block">Browse PS4 Games</a>
                    </div>
                </div>

                <!-- Xbox -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-xbox h-3"></div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Xbox_one_logo.svg" alt="Xbox Logo" class="h-12">
                            <h2 class="text-2xl font-bold ml-3">Xbox</h2>
                        </div>

                        <p class="text-gray-600 mb-6">Enter the world of Xbox with its powerful hardware and extensive game library. From exclusive titles to multi-platform releases, we have everything an Xbox gamer could want.</p>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Popular Xbox Games:</h3>
                            <ul class="list-disc pl-5 text-gray-600">
                                <li>Halo: Master Chief Collection</li>
                                <li>Forza Horizon 5</li>
                                <li>Gears 5</li>
                                <li>Sea of Thieves</li>
                                <li>Fable</li>
                            </ul>
                        </div>

                        <a href="{{ route('products.index') }}?platforms=15&sort=newest" class="bg-xbox hover:bg-green-700 text-white py-2 px-4 rounded font-medium inline-block">Browse Xbox Games</a>
                    </div>
                </div>

                <!-- Nintendo Switch -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-nintendo h-3"></div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5d/Nintendo_Switch_Logo.svg" alt="Nintendo Switch Logo" class="h-12">
                            <h2 class="text-2xl font-bold ml-3">Nintendo Switch</h2>
                        </div>

                        <p class="text-gray-600 mb-6">Play at home or on the go with the versatile Nintendo Switch. Discover Nintendo's beloved franchises and indie gems in our extensive collection of Switch games.</p>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Popular Switch Games:</h3>
                            <ul class="list-disc pl-5 text-gray-600">
                                <li>The Legend of Zelda: Breath of the Wild</li>
                                <li>Animal Crossing: New Horizons</li>
                                <li>Super Mario Odyssey</li>
                                <li>Pokémon Scarlet & Violet</li>
                                <li>Mario Kart 8 Deluxe</li>
                            </ul>
                        </div>

                        <a href="{{ route('products.index') }}?platforms=16&sort=newest" class="bg-nintendo hover:bg-red-700 text-white py-2 px-4 rounded font-medium inline-block">Browse Switch Games</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Comparison -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center font-heading">Platform Comparison</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-4 px-6 text-left font-bold">Feature</th>
                            <th class="py-4 px-6 text-center font-bold">PlayStation 4</th>
                            <th class="py-4 px-6 text-center font-bold">Xbox</th>
                            <th class="py-4 px-6 text-center font-bold">Nintendo Switch</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="py-4 px-6 text-gray-800 font-medium">Graphics</td>
                            <td class="py-4 px-6 text-center text-gray-600">High-definition with HDR support</td>
                            <td class="py-4 px-6 text-center text-gray-600">4K capabilities with HDR</td>
                            <td class="py-4 px-6 text-center text-gray-600">HD in docked mode, 720p handheld</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-gray-800 font-medium">Portability</td>
                            <td class="py-4 px-6 text-center text-gray-600">Home console only</td>
                            <td class="py-4 px-6 text-center text-gray-600">Home console only</td>
                            <td class="py-4 px-6 text-center text-gray-600">Hybrid (home & portable)</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-gray-800 font-medium">Online Service</td>
                            <td class="py-4 px-6 text-center text-gray-600">PlayStation Plus</td>
                            <td class="py-4 px-6 text-center text-gray-600">Xbox Live Gold / Game Pass</td>
                            <td class="py-4 px-6 text-center text-gray-600">Nintendo Switch Online</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-gray-800 font-medium">Notable Exclusives</td>
                            <td class="py-4 px-6 text-center text-gray-600">God of War, Uncharted, Spider-Man</td>
                            <td class="py-4 px-6 text-center text-gray-600">Halo, Forza, Gears of War</td>
                            <td class="py-4 px-6 text-center text-gray-600">Mario, Zelda, Pokémon</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-gray-800 font-medium">Multiplayer Focus</td>
                            <td class="py-4 px-6 text-center text-gray-600">Online & Single Player</td>
                            <td class="py-4 px-6 text-center text-gray-600">Strong Online & Co-op</td>
                            <td class="py-4 px-6 text-center text-gray-600">Local Multiplayer Emphasis</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Latest Releases -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center font-heading">Latest Releases</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- PS4 Latest Releases -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-4 h-4 bg-ps4 rounded-full mr-2"></div>
                        <h3 class="text-xl font-bold">PlayStation 4</h3>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Final Fantasy XVI</span>
                                    <span class="text-sm text-gray-500">RPG</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Resident Evil 4 Remake</span>
                                    <span class="text-sm text-gray-500">Horror</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Hogwarts Legacy</span>
                                    <span class="text-sm text-gray-500">Action RPG</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Star Wars Jedi: Survivor</span>
                                    <span class="text-sm text-gray-500">Action-Adventure</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=11&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Street Fighter 6</span>
                                    <span class="text-sm text-gray-500">Fighting</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Xbox Latest Releases -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-4 h-4 bg-xbox rounded-full mr-2"></div>
                        <h3 class="text-xl font-bold">Xbox</h3>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=4&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Starfield</span>
                                    <span class="text-sm text-gray-500">RPG</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=4&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Forza Motorsport</span>
                                    <span class="text-sm text-gray-500">Racing</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=4&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Diablo IV</span>
                                    <span class="text-sm text-gray-500">Action RPG</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=4&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Redfall</span>
                                    <span class="text-sm text-gray-500">FPS</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=4&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Assassin's Creed Mirage</span>
                                    <span class="text-sm text-gray-500">Action-Adventure</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Nintendo Switch Latest Releases -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-4 h-4 bg-nintendo rounded-full mr-2"></div>
                        <h3 class="text-xl font-bold">Nintendo Switch</h3>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=10&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">The Legend of Zelda: Tears of the Kingdom</span>
                                    <span class="text-sm text-gray-500">Adventure</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=10&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Pikmin 4</span>
                                    <span class="text-sm text-gray-500">Strategy</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=10&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Metroid Prime 4</span>
                                    <span class="text-sm text-gray-500">Action-Adventure</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=10&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Fire Emblem Engage</span>
                                    <span class="text-sm text-gray-500">Strategy RPG</span>
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="{{ route('products.index') }}?platforms=10&sort=newest" class="flex items-center">
                                    <span class="flex-grow font-medium text-gray-800 hover:text-primary">Kirby's Return to Dream Land Deluxe</span>
                                    <span class="text-sm text-gray-500">Platformer</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded font-medium inline-block">View All Games</a>
            </div>
        </div>
    </section>

    <!-- Accessories -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center font-heading">Gaming Accessories</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">PlayStation Accessories</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-ps4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>DualShock 4 Controllers</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-ps4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>PlayStation VR</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-ps4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Charging Stations</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-ps4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Headsets</span>
                        </li>
                    </ul>
                    <a href="{{ route('products.index') }}?type=merchandise&platforms=11&sort=newest" class="text-ps4 hover:underline font-medium">View PS4 Accessories →</a>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Xbox Accessories</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-xbox mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Xbox Controllers</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-xbox mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Play & Charge Kits</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-xbox mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Expansion Drives</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-xbox mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Gaming Headsets</span>
                        </li>
                    </ul>
                    <a href="{{ route('products.index') }}?type=merchandise&platforms=4&sort=newest" class="text-xbox hover:underline font-medium">View Xbox Accessories →</a>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Nintendo Switch Accessories</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-nintendo mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Joy-Cons & Pro Controllers</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-nintendo mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Carrying Cases</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-nintendo mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Screen Protectors</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-nintendo mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>MicroSD Cards</span>
                        </li>
                    </ul>
                    <a href="{{ route('products.index') }}?type=merchandise&platforms=10&sort=newest" class="text-nintendo hover:underline font-medium">View Switch Accessories →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
