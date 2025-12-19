{{-- File: resources/views/rooms/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Hotelux - Our Rooms')

@section('content')
    {{-- BAGIAN 1: HERO HEADER (Gaya disamakan dengan Home) --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
             style="background-image: url('{{ asset('images/room-header-bg.jpg') }}');">

        <div class="absolute inset-0 bg-black/60"></div>

        <div class="relative container mx-auto px-6 text-center z-10">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in-up">
                Our Accommodations
            </h1>
            <p class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto animate-fade-in-up delay-100">
                Experience comfort like never before in our meticulously designed rooms and suites.
            </p>
        </div>
    </section>

    {{-- BAGIAN 2: LIST KAMAR --}}
    <section class="py-16 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6">

            <div class="flex justify-between items-center mb-10 border-b border-gray-800 pb-4">
                <h2 class="text-xl font-semibold text-white">Available Rooms</h2>
                <div class="text-gray-400 text-sm">
                    Showing all categories
                </div>
            </div>

            <div id="rooms-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-500">
                    <span class="material-icons-outlined text-4xl animate-spin mb-2">refresh</span>
                    <p class="italic">Loading rooms catalogue...</p>
                </div>
            </div>

        </div>
    </section>
@endsection
