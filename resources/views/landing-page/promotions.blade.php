<section id="promotions" class="py-24 bg-gray-800 relative overflow-hidden">
    {{-- Decorative Background Element --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-600/5 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2">
    </div>
    <div
        class="absolute bottom-0 left-0 w-64 h-64 bg-amber-600/5 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
            <div class="max-w-2xl">
                <h4 class="text-amber-500 font-semibold tracking-wider uppercase mb-2">Special Offers</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Exclusive Promotions</h2>
                <p class="text-gray-400 mt-4 text-lg">
                    Enhance your stay with our curated packages and limited-time offers.
                </p>
            </div>

            <a href="#"
                class="group flex items-center gap-2 text-white border-b border-amber-500 pb-1 hover:text-amber-500 transition duration-300">
                <span>View all offers</span>
                <span
                    class="material-icons-outlined text-sm group-hover:translate-x-1 transition duration-300">arrow_forward</span>
            </a>
        </div>

        {{-- Grid Content (Senada dengan Rooms) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($promotions as $promo)
                <div
                    class="bg-gray-900 rounded-2xl overflow-hidden shadow-xl border border-gray-800 group hover:border-amber-600/50 transition duration-300 flex flex-col">
                    {{-- Image Area --}}
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $promo->image_url }}" alt="{{ $promo->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                        {{-- Overlay Gradient --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>

                        {{-- Badge --}}
                        <div
                            class="absolute top-4 right-4 bg-amber-600 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wide shadow-lg">
                            Limited Time
                        </div>
                    </div>

                    {{-- Content Area --}}
                    <div class="p-8 flex flex-col flex-grow">
                        <h3
                            class="text-xl font-bold text-white mb-3 group-hover:text-amber-500 transition duration-300">
                            {{ $promo->title }}
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 flex-grow leading-relaxed">
                            {{ $promo->description }}
                        </p>

                        {{-- Promo Code Box --}}
                        <div class="mt-auto">
                            <div
                                class="bg-gray-800 rounded-xl p-1 flex items-center border border-gray-700 border-dashed">
                                <div class="flex-1 px-4 py-2">
                                    <span class="block text-xs text-gray-500 uppercase font-semibold">Promo Code</span>
                                    <span
                                        class="block text-amber-500 font-mono font-bold text-lg tracking-wider">{{ $promo->promo_code }}</span>
                                </div>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $promo->promo_code }}'); alert('Code copied to clipboard!');"
                                    class="bg-gray-700 hover:bg-amber-600 text-white p-3 rounded-lg transition duration-300 shadow-lg"
                                    title="Copy Code">
                                    <span class="material-icons-outlined text-sm">content_copy</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
