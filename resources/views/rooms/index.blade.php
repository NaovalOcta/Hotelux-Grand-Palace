@extends('layouts.app')

@section('title', 'All Accommodations - Hotelux')

@section('content')
    {{-- Page Header --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
        style="background-image: url('{{ asset('images/room-header-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative container mx-auto px-6 text-center z-10">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in-up">
                Our Accommodations
            </h1>
            <p class="text-gray-200 text-lg max-w-2xl mx-auto animate-fade-in-up delay-100">
                Discover your perfect sanctuary in the heart of the city.
            </p>
        </div>
    </section>

    {{-- Room List --}}
    <section class="py-20 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 gap-12">
                @forelse($rooms as $room)
                    @php
                        // LOGIKA PERBAIKAN: Safe Decoding
                        // 1. Gallery Images
                        $images = $room->gallery_images;
                        if (is_string($images)) {
                            $images = json_decode($images, true);
                        }
                        // Pastikan jadi array, ambil gambar pertama atau placeholder
                        $firstImage =
                            is_array($images) && count($images) > 0
                                ? $images[0]
                                : 'https://via.placeholder.com/800x600?text=No+Image';

                        // 2. Amenities
                        $amenities = $room->amenities;
                        if (is_string($amenities)) {
                            $amenities = json_decode($amenities, true);
                        }
                        // Jika gagal decode atau null, jadikan array kosong
                        if (!is_array($amenities)) {
                            $amenities = [];
                        }

                        // 3. Rate Plans (Harga)
                        $ratePlans = $room->rate_plans;
                        if (is_string($ratePlans)) {
                            $ratePlans = json_decode($ratePlans, true);
                        }
                        $price = 0;
                        if (is_array($ratePlans) && count($ratePlans) > 0) {
                            $price = $ratePlans[0]['price_per_night'] ?? 0;
                        }
                    @endphp

                    <div
                        class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl flex flex-col lg:flex-row group border border-gray-700">
                        {{-- Image Column --}}
                        <div class="lg:w-1/2 relative h-64 lg:h-auto overflow-hidden">
                            <img src="{{ $firstImage }}" alt="{{ $room->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-700">

                            {{-- Badge --}}
                            <div
                                class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white px-3 py-1 rounded-full text-sm flex items-center gap-1">
                                <span class="material-icons-outlined text-sm">open_in_full</span>
                                {{ $room->size_m2 }} m²
                            </div>
                        </div>

                        {{-- Details Column --}}
                        <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex flex-col md:flex-row justify-between items-start mb-6 gap-4">
                                <div>
                                    <h3 class="text-3xl font-bold text-white mb-2 leading-tight">{{ $room->name }}</h3>
                                    <div class="flex items-center gap-3 text-amber-500 font-medium text-sm">
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-outlined text-base">visibility</span>
                                            {{ $room->view_type }}
                                        </span>
                                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-outlined text-base">bed</span>
                                            {{ $room->bed_type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-left md:text-right bg-gray-700/50 p-3 rounded-lg md:bg-transparent md:p-0">
                                    <p class="text-sm text-gray-400">Starts from</p>
                                    <p class="text-2xl font-bold text-amber-400">Rp {{ number_format($price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">/night</p>
                                </div>
                            </div>

                            <p class="text-gray-300 mb-8 leading-relaxed border-l-2 border-amber-600 pl-4">
                                {{ $room->description }}
                            </p>

                            {{-- Amenities Grid (SAFE LOOP) --}}
                            <div class="mb-8">
                                <h4 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider text-opacity-80">
                                    Room Features</h4>
                                <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                                    @foreach (array_slice($amenities, 0, 6) as $amenity)
                                        <div class="flex items-center text-gray-400 text-sm">
                                            <span
                                                class="material-icons-outlined text-amber-500 text-sm mr-2">check_circle</span>
                                            {{ $amenity }}
                                        </div>
                                    @endforeach

                                    @if (count($amenities) > 6)
                                        <div class="flex items-center text-amber-600 text-sm font-medium italic">
                                            +{{ count($amenities) - 6 }} more amenities
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-4 mt-auto">
                                <button
                                    class="flex-1 bg-amber-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-amber-700 transition flex items-center justify-center gap-2">
                                    <span class="material-icons-outlined">calendar_today</span>
                                    Book Now
                                </button>
                                <button
                                    class="flex-1 border border-gray-600 text-gray-300 px-6 py-3 rounded-lg font-bold hover:bg-gray-700 hover:text-white transition">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <span class="material-icons-outlined text-6xl text-gray-700 mb-4">meeting_room</span>
                        <p class="text-gray-500 text-xl">No rooms available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
