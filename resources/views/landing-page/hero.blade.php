<section class="relative h-screen flex items-center justify-center bg-cover bg-center"
    style="
    background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop');
"
    id="hero-section" <!-- Ditambah ID untuk referensi, JS akan ganti background/img -->
    >
    <!-- Tambah img tag tersembunyi jika ingin JS mengganti src-nya, atau biarkan JS ganti background-image -->
    <img id="hero-image" src="https://placehold.co/1920x1080/2d3748/cccccc?text=Loading+Hero..."
        alt="Hero Background" class="absolute inset-0 w-full h-screen object-cover -z-10 opacity-60">

    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative text-center text-white z-1 px-4">
        <!-- Nama Hotel (ditambah class hotel-name) -->
        <h1 class="hotel-name text-5xl md:text-7xl font-bold mb-4">
            Welcome to Hotelux
        </h1>
        <!-- Tagline (ditambah ID) -->
        <p id="hero-tagline" class="text-xl md:text-2xl mb-8">
            Experience luxury like never before.
        </p>
        <a href="#"
            class="bg-cyan-500 text-gray-900 px-8 py-3 rounded-full font-semibold text-lg hover:bg-cyan-400 transition">Explore
            Rooms</a>
    </div>
</section>
