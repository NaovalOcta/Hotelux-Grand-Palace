@php
    // Helper untuk mengambil data hotel jika view ini di-include di halaman yang mungkin tidak lewat HomeController
    // Namun idealnya gunakan View Composer. Untuk sekarang kita gunakan null coalescing.
    $hotelInfo = $hotel ?? \App\Models\HotelProfile::first();
    $contact = $hotelInfo->contact ?? [];
    $socials = $hotelInfo->social_links ?? [];
    $address = $hotelInfo->address ?? [];
@endphp

<footer class="bg-gray-950 text-white pt-20 pb-10 border-t border-gray-800">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            {{-- Brand --}}
            <div>
                <h3 class="text-2xl font-bold text-white mb-6 tracking-wider">HOTELUX</h3>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    {{ $hotelInfo->description_short ?? 'Luxury stay.' }}
                </p>
                <div class="flex gap-4">
                    @foreach ($socials as $platform => $link)
                        <a href="{{ $link }}"
                            class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-gray-400 hover:bg-amber-600 hover:text-white transition">
                            {{-- Simple mapping for icons --}}
                            <i class="ri-{{ strtolower($platform) }}-fill text-lg"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-200">Quick Links</h4>
                <ul class="space-y-4 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-500 transition">Home</a></li>
                    <li><a href="{{ route('rooms') }}" class="hover:text-amber-500 transition">Rooms & Suites</a>
                    </li>
                    <li><a href="#facilities" class="hover:text-amber-500 transition">Facilities</a></li>
                    <li><a href="#promotions" class="hover:text-amber-500 transition">Special Offers</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-200">Contact Us</h4>
                <ul class="space-y-4 text-gray-500">
                    <li class="flex items-start gap-3">
                        <span class="material-icons-outlined text-amber-600 mt-1">location_on</span>
                        <span>
                            {{ $address['street'] ?? '' }}<br>
                            {{ $address['city'] ?? '' }}, {{ $address['state'] ?? '' }} {{ $address['zip_code'] ?? '' }}
                        </span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-amber-600">phone</span>
                        <span>{{ $contact['phone'] ?? '+62 123 456 789' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-amber-600">email</span>
                        <span>{{ $contact['email'] ?? 'info@hotelux.com' }}</span>
                    </li>
                </ul>
            </div>

            {{-- Newsletter (Static for now) --}}
            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-200">Newsletter</h4>
                <p class="text-gray-500 mb-4 text-sm">Subscribe to receive updates and exclusive offers.</p>
                <form class="flex flex-col gap-3">
                    <input type="email" placeholder="Your email address"
                        class="bg-gray-900 border border-gray-800 rounded px-4 py-3 text-white focus:outline-none focus:border-amber-600">
                    <button type="button"
                        class="bg-amber-600 text-white font-bold py-3 rounded hover:bg-amber-700 transition">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-900 pt-8 text-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} {{ $hotelInfo->name ?? 'Hotelux' }}. All rights reserved.</p>
        </div>
    </div>
</footer>
