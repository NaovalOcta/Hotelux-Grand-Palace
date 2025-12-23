@extends('layouts.app')

@section('title', 'Our Accommodations - Hotelux')

@section('content')
    {{-- Page Header --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
             style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-gray-900/70"></div>
        <div class="relative container mx-auto px-6 text-center z-10">
            <h4 class="text-amber-500 font-bold tracking-widest uppercase mb-4 animate-fade-in-down">
                Stay With Us
            </h4>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in-up">
                Our Accommodations
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto animate-fade-in-up delay-100">
                Discover your perfect sanctuary. From cozy city-view rooms to expansive family suites.
            </p>
        </div>
    </section>

    {{-- Room List --}}
    <section class="py-20 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 gap-16">
                @forelse($rooms as $room)
                    @php
                        // 1. DATA PREPARATION (Amenities & Price)
                        $amenities = is_string($room->amenities) ? json_decode($room->amenities, true) : $room->amenities;
                        $amenities = is_array($amenities) ? $amenities : [];

                        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
                        $price = $ratePlans[0]['price_per_night'] ?? 0;

                        // 2. IMAGE LOGIC (SMART CHECK - INI YANG PENTING)
                        $images = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;
                        $firstImg = $images[0] ?? null;

                        // Default Placeholder
                        $imgSrc = 'https://via.placeholder.com/800x600?text=No+Image';

                        if ($firstImg) {
                            // Cek apakah ini URL Eksternal (http...) atau File Lokal
                            $imgSrc = filter_var($firstImg, FILTER_VALIDATE_URL)
                                ? $firstImg
                                : asset('storage/' . $firstImg); // Tambahkan 'storage/' untuk file lokal
                        }
                    @endphp

                    <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col lg:flex-row group border border-gray-700 hover:border-amber-600/30 transition duration-500">
                        {{-- Image Column --}}
                        <div class="lg:w-1/2 relative h-72 lg:h-auto overflow-hidden">
                            {{-- Gunakan variabel $imgSrc yang sudah diproses --}}
                            <img src="{{ $imgSrc }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                            {{-- Badges --}}
                            <div class="absolute top-4 left-4 flex gap-2">
                                <div class="bg-black/60 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                    {{ $room->view_type }}
                                </div>
                            </div>
                        </div>

                        {{-- Details Column --}}
                        <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex flex-col md:flex-row justify-between items-start mb-6 gap-4">
                                <div>
                                    <h3 class="text-3xl font-bold text-white mb-2 leading-tight group-hover:text-amber-500 transition">{{ $room->name }}</h3>
                                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-outlined text-base text-amber-500">square_foot</span>
                                            {{ $room->size_m2 }} m²
                                        </span>
                                        <span class="w-1 h-1 bg-gray-600 rounded-full"></span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-outlined text-base text-amber-500">bed</span>
                                            {{ $room->bed_type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-left md:text-right">
                                    <p class="text-sm text-gray-400">Starts from</p>
                                    <p class="text-2xl font-bold text-amber-500">Rp {{ number_format($price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">/night</p>
                                </div>
                            </div>

                            <p class="text-gray-400 mb-8 leading-relaxed line-clamp-3">
                                {{ $room->description }}
                            </p>

                            {{-- Amenities Grid --}}
                            <div class="mb-8 p-6 bg-gray-900/50 rounded-2xl border border-gray-700/50">
                                <div class="grid grid-cols-2 gap-y-3 gap-x-4">
                                    @foreach(array_slice($amenities, 0, 4) as $amenity)
                                        <div class="flex items-center text-gray-300 text-sm">
                                            <span class="material-icons-outlined text-amber-600 text-sm mr-2">check_circle</span>
                                            {{ $amenity }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-4 mt-auto">
                                <button class="flex-1 bg-amber-600 text-white px-6 py-3.5 rounded-xl font-bold hover:bg-amber-700 transition flex items-center justify-center gap-2 shadow-lg shadow-amber-600/20">
                                    <span class="material-icons-outlined text-sm">calendar_month</span>
                                    Book Now
                                </button>
                                <button class="px-6 py-3.5 rounded-xl font-bold text-gray-300 hover:text-white hover:bg-gray-700 transition border border-gray-600">
                                    Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-gray-800 rounded-2xl">
                        <span class="material-icons-outlined text-6xl text-gray-600 mb-4">hotel</span>
                        <p class="text-gray-400 text-xl">No rooms available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
