<section id="promotions" class="py-20 bg-amber-600">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between mb-12">
            <h2 class="text-3xl font-bold text-white">Exclusive Offers</h2>
            <a href="#" class="text-white border-b border-white pb-1 hover:opacity-80 mt-4 md:mt-0">View all
                offers</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($promotions as $promo)
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-1 transition duration-300">
                    <img src="{{ $promo->image_url }}" alt="{{ $promo->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-xs font-bold text-amber-600 uppercase tracking-wide mb-2">Limited Time</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $promo->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $promo->description }}</p>

                        <div
                            class="flex items-center justify-between bg-gray-100 p-3 rounded border border-gray-200 border-dashed">
                            <span class="text-sm text-gray-500 font-mono">CODE: <span
                                    class="text-gray-900 font-bold">{{ $promo->promo_code }}</span></span>
                            <button class="text-amber-600 text-sm font-bold hover:underline"
                                onclick="navigator.clipboard.writeText('{{ $promo->promo_code }}'); alert('Code copied!')">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
