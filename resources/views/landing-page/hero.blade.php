<section id="home" class="relative h-screen flex items-center justify-center text-white">
    {{-- Background Image dengan Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ $hotel->hero_image ?? asset('images/default-hero.jpg') }}"
             alt="Hotel Hero"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
        <p class="text-amber-400 font-medium tracking-widest uppercase mb-4 animate-fade-in-down">
            Welcome to {{ $hotel->name }}
        </p>
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight animate-fade-in-up">
            {{ $hotel->tagline }}
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-10 animate-fade-in-up delay-100">
            {{ $hotel->description_short }}
        </p>

        <div class="flex flex-col md:flex-row gap-4 justify-center animate-fade-in-up delay-200">
            <a href="#rooms" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-full font-semibold transition duration-300">
                Book Your Stay
            </a>
            <a href="#about" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-full font-semibold transition duration-300">
                Discover More
            </a>
        </div>
    </div>
</section>
