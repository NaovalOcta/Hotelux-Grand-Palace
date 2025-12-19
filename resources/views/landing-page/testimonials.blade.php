<section id="testimonials" class="py-24 bg-gray-900 text-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-16">Guest Stories</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($testimonials as $testi)
                <div class="bg-gray-800 p-8 rounded-2xl relative">
                    {{-- Quote Icon --}}
                    <span class="absolute top-4 right-6 text-6xl text-gray-700 font-serif opacity-50">"</span>

                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        @for ($i = 0; $i < $testi->rating; $i++)
                            <span class="material-icons-outlined text-sm">star</span>
                        @endfor
                    </div>

                    <p class="text-gray-300 italic mb-6 leading-relaxed">
                        "{{ $testi->quote }}"
                    </p>

                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 bg-amber-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($testi->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-sm">{{ $testi->name }}</h5>
                            <span class="text-xs text-gray-500">{{ $testi->origin }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
