<section id="booking" class="py-20 bg-gray-900 relative">
    <div class="container mx-auto px-6">
        {{-- Card Container --}}
        <div class="bg-gray-800 rounded-3xl p-8 md:p-12 shadow-2xl border border-gray-700 relative overflow-hidden">

            {{-- Background Accent --}}
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-amber-600/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3">
            </div>

            <div class="relative z-10">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Ready to Experience Luxury?</h2>
                    <p class="text-gray-400">Check availability and book your perfect stay today.</p>
                </div>

                {{-- Form Booking --}}
                <form action="#" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">

                        {{-- Check In --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-amber-500 uppercase tracking-wider mb-2">Check
                                In</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 material-icons-outlined text-lg">calendar_today</span>
                                <input type="date" name="check_in"
                                    class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-amber-600 focus:border-transparent outline-none transition duration-300 placeholder-gray-500">
                            </div>
                        </div>

                        {{-- Check Out --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-amber-500 uppercase tracking-wider mb-2">Check
                                Out</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 material-icons-outlined text-lg">event</span>
                                <input type="date" name="check_out"
                                    class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-amber-600 focus:border-transparent outline-none transition duration-300 placeholder-gray-500">
                            </div>
                        </div>

                        {{-- Room Type --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-amber-500 uppercase tracking-wider mb-2">Room
                                Type</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 material-icons-outlined text-lg">king_bed</span>
                                <select name="room_type"
                                    class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl py-3.5 pl-12 pr-10 appearance-none focus:ring-2 focus:ring-amber-600 focus:border-transparent outline-none transition duration-300 cursor-pointer">
                                    <option value="" class="text-gray-400">All Rooms</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 material-icons-outlined pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-amber-600/20 transform hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2">
                                <span class="material-icons-outlined">search</span>
                                <span>Check Availability</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
