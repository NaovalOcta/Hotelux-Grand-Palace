<section id="about" class="py-24 bg-gray-900 text-white">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-16">

            {{-- Image Grid --}}
            <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" alt="Hotel Interior" class="rounded-lg object-cover h-64 w-full translate-y-8">
                <img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c" alt="Hotel Lobby" class="rounded-lg object-cover h-64 w-full">
            </div>

            {{-- Text Content --}}
            <div class="lg:w-1/2">
                <h4 class="text-amber-500 font-semibold tracking-wider uppercase mb-2">About Us</h4>
                <h2 class="text-4xl font-bold mb-6">Experience Unrivaled Luxury</h2>
                <p class="text-gray-400 mb-8 leading-relaxed">
                    {{ $hotel->description_long }}
                </p>

                {{-- Key Highlights Loop --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(is_array($hotel->key_highlights) || is_object($hotel->key_highlights))
                        @foreach($hotel->key_highlights as $highlight)
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-800 p-3 rounded-lg text-amber-500">
                                <span class="material-icons-outlined">{{ $highlight['icon'] ?? 'star' }}</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-lg">{{ $highlight['title'] }}</h5>
                                <p class="text-sm text-gray-500">{{ $highlight['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
