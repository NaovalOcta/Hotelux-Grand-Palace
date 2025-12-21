{{-- File: resources/views/contact/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact Us - Hotelux')

@section('content')
    {{-- BAGIAN 1: HERO HEADER --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
        style="background-image: url('https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=1920&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-gray-900/70"></div>
        <div class="relative container mx-auto px-6 text-center z-10">
            <h4 class="text-amber-500 font-bold tracking-widest uppercase mb-4 animate-fade-in-down">
                Get in Touch
            </h4>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                Contact Us
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-100">
                We are here to assist you with any inquiries or special requests.
            </p>
        </div>
    </section>

    {{-- BAGIAN 2: CONTENT GRID --}}
    <section class="py-24 bg-gray-900 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-600/5 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                {{-- KOLOM KIRI: Informasi Kontak --}}
                <div class="space-y-10">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-6">Contact Information</h2>
                        <p class="text-gray-400 leading-relaxed mb-8">
                            Reach out to our concierge team directly or visit us at our prime location. We are available
                            24/7 to ensure your stay is perfect.
                        </p>
                    </div>

                    @php
                        // Ambil data dari variabel $hotel (dikirim dari controller)
                        // Gunakan null coalescing agar aman
                        $address = $hotel->address ?? [];
                        if (is_string($address)) {
                            $address = json_decode($address, true);
                        }

                        $contact = $hotel->contact ?? [];
                        if (is_string($contact)) {
                            $contact = json_decode($contact, true);
                        }
                    @endphp

                    <div class="space-y-6">
                        {{-- Address --}}
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-800 p-3 rounded-lg text-amber-500 shadow-lg">
                                <span class="material-icons-outlined text-2xl">location_on</span>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Our Location</h4>
                                <p class="text-gray-400 mt-1">
                                    {{ $address['street'] ?? 'Jalan Jenderal Sudirman' }}<br>
                                    {{ $address['city'] ?? 'Jakarta' }}, {{ $address['state'] ?? '' }}
                                    {{ $address['zip_code'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-800 p-3 rounded-lg text-amber-500 shadow-lg">
                                <span class="material-icons-outlined text-2xl">email</span>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Email Us</h4>
                                <p class="text-gray-400 mt-1">
                                    <a href="mailto:{{ $contact['email'] ?? 'info@hotelux.com' }}"
                                        class="hover:text-amber-500 transition">
                                        {{ $contact['email'] ?? 'info@hotelux.com' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-800 p-3 rounded-lg text-amber-500 shadow-lg">
                                <span class="material-icons-outlined text-2xl">phone</span>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Call Us</h4>
                                <p class="text-gray-400 mt-1">
                                    <a href="tel:{{ $contact['phone'] ?? '+62 123 456 789' }}"
                                        class="hover:text-amber-500 transition">
                                        {{ $contact['phone'] ?? '+62 123 456 789' }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Map Embed (Statis / Generic Jakarta Map) --}}
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-800 h-64 mt-8">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24097834483!2d106.75947804928135!3d-6.229746487844038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Special%20Capital%20Region%20of%20Jakarta!5e0!3m2!1sen!2sid!4v1709221234567!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- KOLOM KANAN: Contact Form --}}
                <div class="bg-gray-800 rounded-3xl p-8 md:p-10 shadow-2xl border border-gray-700">
                    <h3 class="text-2xl font-bold text-white mb-6">Send a Message</h3>

                    {{-- Alert Success --}}
                    @if (session('success'))
                        <div
                            class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                            <span class="material-icons-outlined">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                                <input type="text" name="name" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition placeholder-gray-600"
                                    placeholder="John Doe">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                                <input type="email" name="email" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition placeholder-gray-600"
                                    placeholder="john@example.com">
                            </div>

                            {{-- Subject --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Subject</label>
                                <input type="text" name="subject" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition placeholder-gray-600"
                                    placeholder="Reservation Inquiry">
                            </div>

                            {{-- Message --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Message</label>
                                <textarea name="message" rows="4" required
                                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition placeholder-gray-600"
                                    placeholder="How can we help you?"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-amber-600/20 transform hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2">
                                <span>Send Message</span>
                                <span class="material-icons-outlined text-sm">send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
