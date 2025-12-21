<section id="rooms" class="py-24 bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Our Luxurious Rooms</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Choose from our variety of suites designed for your ultimate comfort.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($rooms as $room)
                @php
                    // Pastikan gallery_images berbentuk array (handle string JSON jika cast gagal)
                    $images = is_string($room->gallery_images)
                        ? json_decode($room->gallery_images, true)
                        : $room->gallery_images;
                    $coverImage = $images[0] ?? 'https://via.placeholder.com/400x300';

                    // Ambil harga terendah/pertama
                    $rates = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
                    $price = $rates[0]['price_per_night'] ?? 0;
                @endphp

                <div
                    class="bg-gray-900 rounded-xl overflow-hidden shadow-xl group hover:-translate-y-2 transition duration-300">
                    {{-- Image --}}
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $coverImage }}" alt="{{ $room->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 right-4 bg-amber-600 text-white text-xs font-bold px-3 py-1 rounded">
                            {{ $room->size_m2 }} m²
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $room->name }}</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $room->description }}</p>

                        {{-- Fasilitas Kecil --}}
                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-6">
                            <span class="flex items-center gap-1">
                                <span class="material-icons-outlined text-base">person</span>
                                {{ $room->occupancy['max_adults'] ?? 2 }} Adults
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-icons-outlined text-base">bed</span>
                                {{ $room->bed_type }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-800 pt-4">
                            <div>
                                <span class="text-xs text-gray-500 block">Starts from</span>
                                <span class="text-amber-500 font-bold text-lg">
                                    Rp {{ number_format($price, 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ route('rooms.index') }}"
                                class="text-white hover:text-amber-500 font-medium text-sm transition">
                                View Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    No rooms available at the moment.
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('rooms.index') }}"
                class="inline-block border border-amber-600 text-amber-500 hover:bg-amber-600 hover:text-white px-8 py-3 rounded-full transition duration-300">
                View All Room Types
            </a>
        </div>
    </div>
</section>
