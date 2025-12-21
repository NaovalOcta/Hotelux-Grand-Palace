<header class="absolute top-0 left-0 right-0 z-10">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center relative">
        <div class="hotel-name text-2xl font-bold text-white">
            <a href="#">Hotelux</a>
        </div>

        <ul class="hidden lg:flex space-x-8 items-center text-white">
            <li><a href="{{ route('home') }}" class="hover:text-cyan-400">Home</a></li>
            <li><a href="{{ route('rooms') }}" class="hover:text-cyan-400">Rooms</a></li>
            <li><a href="{{ route('facilities') }}" class="hover:text-cyan-400">Facilities</a></li>
            <li><a href="{{ route('contact.index') }}" class="hover:text-cyan-400">Contact</a></li>
            <li>
                <a href="#"
                    class="bg-cyan-500 text-gray-900 px-6 py-2 rounded-full font-semibold hover:bg-cyan-400 transition">Book
                    Now</a>
            </li>
        </ul>

        <button id="mobile-menu-btn" class="lg:hidden text-white text-2xl focus:outline-none">
            <i id="mobile-menu-icon" class="ri-menu-line"></i>
        </button>

        <div id="mobile-menu"
            class="hidden absolute top-full left-0 w-full bg-gray-900 shadow-lg border-t border-gray-800">
            <ul class="flex flex-col p-6 space-y-4 text-white text-center">
                <li><a href="{{ route('home') }}" class="block hover:text-cyan-400">Home</a></li>
                <li><a href="{{ route('rooms') }}" class="block hover:text-cyan-400">Rooms</a></li>
                <li><a href="{{ route('facilities') }}" class="block hover:text-cyan-400">Facilities</a></li>
                <li><a href="{{ route('contact.index') }}" class="block hover:text-cyan-400">Contact</a></li>
                <li>
                    <a href="#"
                        class="block bg-cyan-500 text-gray-900 px-6 py-2 rounded-full font-semibold hover:bg-cyan-400 transition">Book
                        Now</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
