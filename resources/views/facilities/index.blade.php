@extends('layouts.app')

@section('title', 'Facilities - Hotelux')

@section('content')
    {{-- BAGIAN 1: HERO SECTION (Konsisten dengan Rooms & Contact) --}}
    <section class="relative pt-40 pb-20 flex items-center justify-center min-h-[50vh] bg-cover bg-center bg-fixed"
        style="background-image: url('https://images.unsplash.com/photo-1571896349842-6e5a51335022?q=80&w=1920&auto=format&fit=crop');">

        {{-- Overlay Gelap --}}
        <div class="absolute inset-0 bg-gray-900/70"></div>

        {{-- Konten Tengah --}}
        <div class="relative container mx-auto px-6 text-center z-10">
            <h4 class="text-amber-500 font-bold tracking-widest uppercase mb-4 animate-fade-in-down">
                World Class Amenities
            </h4>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                Our Facilities
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-100">
                Indulge in our premium facilities designed for your ultimate relaxation and wellness. Experience luxury
                beyond just a stay.
            </p>
        </div>
    </section>

    {{-- BAGIAN 2: DAFTAR FASILITAS --}}
    <section class="py-24 bg-gray-900 relative">
        {{-- Aksen Dekorasi --}}
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>

        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Facility Card 1: Infinity Pool --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop"
                            alt="Infinity Pool"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">pool</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Infinity Pool
                        </h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Relax in our rooftop infinity pool with breathtaking panoramic views of the city skyline. Open
                            from 6 AM to 10 PM.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Heated Water</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Poolside Bar</li>
                        </ul>
                    </div>
                </div>

                {{-- Facility Card 2: Fitness Center --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=800&auto=format&fit=crop"
                            alt="Fitness Center"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">fitness_center</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Fitness Center
                        </h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Stay active with our state-of-the-art gym equipment, personal trainers, and yoga studio. Open
                            24/7 for guests.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Technogym Equipment</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Personal Trainer</li>
                        </ul>
                    </div>
                </div>

                {{-- Facility Card 3: Spa & Wellness --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=800&auto=format&fit=crop"
                            alt="Spa" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">spa</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Grand Spa</h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Rejuvenate your body and mind with our exclusive spa treatments, massage therapies, and sauna
                            sessions.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Full Body Massage</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Sauna & Jacuzzi</li>
                        </ul>
                    </div>
                </div>

                {{-- Facility Card 4: Fine Dining --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=800&auto=format&fit=crop"
                            alt="Restaurant"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">restaurant</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Sky Lounge
                            Dining</h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Savor exquisite international cuisine prepared by our Michelin-starred chefs in an elegant
                            rooftop setting.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Western & Asian</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Private Room Available</li>
                        </ul>
                    </div>
                </div>

                {{-- Facility Card 5: Conference Room --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=800&auto=format&fit=crop"
                            alt="Conference"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">meeting_room</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Business Center
                        </h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Host successful meetings and events in our modern conference rooms equipped with high-speed
                            internet and AV systems.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                High Speed WiFi</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Projector & Sound System</li>
                        </ul>
                    </div>
                </div>

                {{-- Facility Card 6: Valet Parking --}}
                <div
                    class="group bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-gray-700 hover:border-amber-600/50">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a?q=80&w=800&auto=format&fit=crop"
                            alt="Parking" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                    <div class="p-8 relative -mt-16">
                        <div
                            class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg rotate-3 group-hover:rotate-0 transition duration-300">
                            <span class="material-icons-outlined text-2xl">local_parking</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-amber-500 transition">Valet Parking
                        </h3>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Enjoy hassle-free arrival and departure with our 24-hour secure valet parking service for all
                            guests.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center gap-2"><span
                                    class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> 24/7 Security</li>
                            <li class="flex items-center gap-2"><span
                                    class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> EV Charging Station</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
