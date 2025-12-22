<header class="absolute top-0 left-0 right-0 z-10">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center relative">
        <div class="hotel-name text-2xl font-bold text-white">
            <a href="#">Hotelux</a>
        </div>

        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="text-white hover:text-amber-500 transition">Home</a>
            <a href="{{ route('rooms.index') }}" class="text-white hover:text-amber-500 transition">Rooms</a>
            <a href="{{ route('facilities.index') }}" class="text-white hover:text-amber-500 transition">Facilities</a>
            <a href="{{ route('contact.index') }}" class="text-white hover:text-amber-500 transition">Contact</a>

            @auth
                {{-- JIKA SUDAH LOGIN --}}
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white hover:text-amber-500 transition focus:outline-none">
                        <div
                            class="w-8 h-8 rounded-full bg-amber-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <span class="material-icons-outlined text-sm">expand_more</span>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div
                        class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-xl border border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform z-50">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-t-lg">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="#"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-t-lg">
                                My Bookings
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-400 hover:bg-gray-700 hover:text-red-300 rounded-b-lg">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- JIKA BELUM LOGIN (GUEST) --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-amber-500 font-medium transition">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2 rounded-full font-bold transition shadow-lg">
                        Join Us
                    </a>
                </div>
            @endauth
        </div>

        <button id="mobile-menu-btn" class="lg:hidden text-white text-2xl focus:outline-none">
            <i id="mobile-menu-icon" class="ri-menu-line"></i>
        </button>

        <div id="mobile-menu"
            class="hidden absolute top-full left-0 w-full bg-gray-900 shadow-lg border-t border-gray-800">
            <ul class="flex flex-col p-6 space-y-4 text-white text-center">
                <li><a href="{{ route('home') }}" class="block hover:text-cyan-400">Home</a></li>
                <li><a href="{{ route('rooms.index') }}" class="block hover:text-cyan-400">Rooms</a></li>
                <li><a href="{{ route('facilities.index') }}" class="block hover:text-cyan-400">Facilities</a></li>
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
