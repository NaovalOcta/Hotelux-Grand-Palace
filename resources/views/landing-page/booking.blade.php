<section id="booking-section" class="py-20 bg-gray-900">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-semibold text-white text-center mb-12">
                    Book Your Stay
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="relative rounded-lg overflow-hidden shadow-xl h-[200px] lg:h-[400px]">
                        <img src="https://xdmrhxrztxyqpfzfzxxd.supabase.co/storage/v1/object/public/hotel_images/Reception-Hotel.jpg"
                            alt="Hotel Scenery" class="absolute inset-0 w-full h-full object-cover" />
                    </div>

                    <div>
                        <form id="booking-form" class="bg-gray-800 p-8 rounded-lg shadow-lg space-y-6 h-full">
                            <div id="booking-message"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="guest-name" class="block text-sm font-medium text-gray-300">Full
                                        Name</label>
                                    <input type="text" id="guest-name" name="guest_name" required
                                        class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                                <div>
                                    <label for="guest-email"
                                        class="block text-sm font-medium text-gray-300">Email</label>
                                    <input type="email" id="guest-email" name="guest_email" required
                                        class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                            </div>
                            <div>
                                <label for="booking-room-select" class="block text-sm font-medium text-gray-300">Room
                                    Type</label>
                                <select id="booking-room-select" name="room_id" required
                                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                                    <option value="">Loading rooms...</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="check-in" class="block text-sm font-medium text-gray-300">Check-in
                                        Date</label>
                                    <input type="date" id="check-in" name="check_in" required
                                        class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 date-input">
                                </div>
                                <div>
                                    <label for="check-out" class="block text-sm font-medium text-gray-300">Check-out
                                        Date</label>
                                    <input type="date" id="check-out" name="check_out" required
                                        class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 date-input">
                                </div>
                            </div>
                            <div>
                                <label for="total-price" class="block text-sm font-medium text-gray-300">Total Price
                                    (IDR)</label>
                                <input type="number" id="total-price" name="total_price" readonly
                                    placeholder="Calculated automatically"
                                    class="mt-1 block w-full bg-gray-600 border border-gray-500 rounded-md shadow-sm py-2 px-3 text-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                            </div>
                            <div>
                                <button type="submit" id="booking-submit-btn"
                                    class="w-full bg-cyan-500 text-gray-900 px-6 py-3 rounded-md font-semibold text-lg hover:bg-cyan-400 transition">
                                    Submit Booking
                                </button>
                            </div>
                            <style>
                                .date-input::-webkit-calendar-picker-indicator {
                                    filter: invert(0.8);
                                }
                            </style>
                        </form>
                    </div>
                </div>
            </div>
        </section>
