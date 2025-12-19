<section id="booking" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 -mt-32 relative z-20">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Check Availability</h2>

            <form action="#" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Check In --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check In</label>
                    <input type="date" name="check_in"
                        class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 p-3 bg-gray-50">
                </div>

                {{-- Check Out --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check Out</label>
                    <input type="date" name="check_out"
                        class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 p-3 bg-gray-50">
                </div>

                {{-- Room Type Select (Dynamic) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                    <select name="room_type"
                        class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 p-3 bg-gray-50">
                        <option value="">All Rooms</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Button --}}
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition duration-300 flex items-center justify-center gap-2">
                        <span class="material-icons-outlined">search</span>
                        Check Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
