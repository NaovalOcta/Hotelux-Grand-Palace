<section id="facilities" class="py-24 bg-gray-900 relative overflow-hidden">
    {{-- Decorative Background --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-amber-600/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">World-Class Facilities</h2>
            <p class="text-gray-400">Everything you need for a perfect stay.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($facilities as $facility)
                <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-xl border border-gray-700 hover:border-amber-500/50 transition duration-300">
                    <h3 class="text-xl font-bold text-amber-500 mb-6">{{ $facility->category }}</h3>

                    <ul class="space-y-4">
                        @foreach($facility->items as $item)
                        <li class="flex items-center text-gray-300">
                            <div class="bg-gray-700 p-2 rounded-lg mr-3 text-amber-400">
                                <span class="material-icons-outlined text-sm">{{ $item['icon'] }}</span>
                            </div>
                            <span class="text-sm font-medium">{{ $item['name'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
