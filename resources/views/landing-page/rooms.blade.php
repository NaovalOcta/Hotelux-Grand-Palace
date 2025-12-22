<section id="rooms" class="py-24 bg-gray-800 relative">
    {{-- Background Accent --}}
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>

    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl">
                <h4 class="text-amber-500 font-semibold tracking-wider uppercase mb-2">Our Accommodations</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Luxurious Rooms & Suites</h2>
                <p class="text-gray-400">
                    Designed for comfort, styled for luxury. Choose the perfect space for your stay.
                </p>
            </div>
            <a href="{{ route('rooms.index') }}"
                class="group flex items-center gap-2 text-white border-b border-amber-500 pb-1 hover:text-amber-500 transition duration-300">
                <span>View all rooms</span>
                <span
                    class="material-icons-outlined text-sm group-hover:translate-x-1 transition duration-300">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($rooms as $room)
                @php
                    // IMAGE LOGIC (SMART CHECK)
                    $images = is_string($room->gallery_images)
                        ? json_decode($room->gallery_images, true)
                        : $room->gallery_images;
                    $firstImg = $images[0] ?? null;

                    $imgSrc = 'https://via.placeholder.com/400x300';
                    if ($firstImg) {
                        $imgSrc = filter_var($firstImg, FILTER_VALIDATE_URL)
                            ? $firstImg
                            : asset('storage/' . $firstImg);
                    }

                    // PRICE LOGIC
                    $ratePlans = is_string($room->rate_plans)
                        ? json_decode($room->rate_plans, true)
                        : $room->rate_plans;
                    $price = $ratePlans[0]['price_per_night'] ?? 0;
                @endphp

                <div
                    class="bg-gray-900 rounded-2xl overflow-hidden shadow-xl group border border-gray-800 hover:border-amber-600/50 transition duration-300 flex flex-col">
                    {{-- Image --}}
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $imgSrc }}" alt="{{ $room->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute top-4 right-4 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full">
                            {{ $room->size_m2 }} m²
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-amber-500 transition">
                            {{ $room->name }}</h3>
                        <p class="text-gray-400 text-sm mb-6 line-clamp-2 flex-grow">{{ $room->description }}</p>

                        <div
                            class="flex items-center gap-4 text-gray-500 text-xs mb-6 uppercase tracking-wider font-semibold">
                            <span class="flex items-center gap-1">
                                <span class="material-icons-outlined text-sm text-amber-600">person</span>
                                {{ $room->occupancy['max_adults'] ?? 2 }} Adults
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-icons-outlined text-sm text-amber-600">bed</span>
                                {{ $room->bed_type }}
                            </span>
                        </div>

                        <div class="flex items-end justify-between pt-4 border-t border-gray-800 mt-auto">
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Starts from</span>
                                <span class="text-amber-500 font-bold text-lg">
                                    Rp {{ number_format($price, 0, ',', '.') }}
                                </span>
                            </div>
                            <button
                                class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-amber-600 transition shadow-lg">
                                <span class="material-icons-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No rooms available to display.
                </div>
            @endforelse
        </div>
    </div>
</section>
