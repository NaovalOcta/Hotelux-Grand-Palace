{{-- File: resources/views/facilities/index.blade.php --}}
@extends('layouts.app')

@section('title', 'World-Class Facilities - Hotelux')

@section('content')
    {{-- BAGIAN 1: PAGE HEADER (Senada dengan halaman Rooms) --}}
    {{-- Pastikan Anda memiliki gambar 'facilities-header-bg.jpg' atau ganti dengan URL gambar lain --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
        style="background-image: url('https://images.unsplash.com/photo-1571896349842-6e53ce41e887?q=80&w=1920&auto=format&fit=crop');">

        {{-- Overlay Gelap --}}
        <div class="absolute inset-0 bg-gray-900/70"></div>

        <div class="relative container mx-auto px-6 text-center z-10">
            <h4 class="text-amber-500 font-bold tracking-widest uppercase mb-4 animate-fade-in-down">
                Experience Luxury
            </h4>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                Our Facilities
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-100">
                Designed for your ultimate comfort and convenience. Whether you're here for business or leisure, we have
                everything you need.
            </p>
        </div>
    </section>

    {{-- BAGIAN 2: DAFTAR FASILITAS --}}
    <section class="py-24 bg-gray-900 relative overflow-hidden">
        {{-- Elemen Dekorasi Background (Blur) --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-600/5 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-amber-600/5 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2">
        </div>

        <div class="container mx-auto px-6 relative z-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                @foreach ($facilities as $index => $facility)
                    @php
                        // LOGIKA SAFE DECODE (Mencegah Error "String Given")
                        $items = $facility->items;
                        if (is_string($items)) {
                            $items = json_decode($items, true);
                        }
                        if (!is_array($items)) {
                            $items = [];
                        }

                        // Menentukan icon utama berdasarkan kategori (opsional, untuk variasi visual)
                        $categoryIcon = match ($facility->category) {
                            'Makanan & Minuman' => 'restaurant',
                            'Kebugaran & Rekreasi' => 'pool',
                            'Bisnis & Acara' => 'business_center',
                            'Layanan Umum' => 'room_service',
                            default => 'star',
                        };
                    @endphp

                    {{-- Card Fasilitas --}}
                    <div
                        class="bg-gray-800 rounded-2xl p-8 border border-gray-700 hover:border-amber-600/50 hover:bg-gray-800/80 transition duration-300 group shadow-xl flex flex-col">

                        {{-- Header Card --}}
                        <div class="flex items-center gap-4 mb-8 border-b border-gray-700 pb-6">
                            <div
                                class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center text-amber-500 shadow-inner group-hover:scale-110 transition duration-300">
                                <span class="material-icons-outlined text-3xl">{{ $categoryIcon }}</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white group-hover:text-amber-500 transition">
                                    {{ $facility->category }}
                                </h3>
                                <p class="text-gray-500 text-sm mt-1">Premium Amenities</p>
                            </div>
                        </div>

                        {{-- List Item --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($items as $item)
                                <div
                                    class="flex items-center gap-3 p-3 rounded-lg bg-gray-900/50 hover:bg-gray-700/50 transition duration-300">
                                    <div class="text-amber-500 flex-shrink-0">
                                        <span
                                            class="material-icons-outlined text-xl">{{ $item['icon'] ?? 'check_circle' }}</span>
                                    </div>
                                    <span class="text-gray-300 font-medium text-sm">{{ $item['name'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BAGIAN 3: CALL TO ACTION (CTA) --}}
    <section class="py-20 bg-amber-600 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Experience It All?</h2>
            <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
                Book your stay today and enjoy full access to all our world-class facilities.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('rooms') }}"
                    class="bg-gray-900 text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition shadow-lg">
                    Book a Room
                </a>
                <a href="https://wa.me/628123456789" target="_blank"
                    class="bg-white text-amber-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg flex items-center justify-center gap-2">
                    <span class="material-icons-outlined">chat</span>
                    Contact Concierge
                </a>
            </div>
        </div>

        {{-- Pattern Overlay --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    </section>
@endsection
