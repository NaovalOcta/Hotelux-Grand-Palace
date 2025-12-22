@extends('layouts.app')

@section('title', 'New Reservation')

@section('content')
<div class="pt-32 pb-20 bg-gray-900 min-h-screen">
    <div class="container mx-auto px-6 max-w-4xl">

        <div class="mb-8">
            <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1 transition">
                <span class="material-icons-outlined text-sm">arrow_back</span> Back to List
            </a>
            <h1 class="text-3xl font-bold text-white">New Reservation</h1>
        </div>

        <div class="bg-gray-800 rounded-xl border border-gray-700 p-8 shadow-xl">
            <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Guest Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Select Guest</label>
                    <select name="user_id" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        <option value="">-- Choose a Registered User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Room Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Room Type</label>
                    <select name="room_type_id" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        @foreach($rooms as $room)
                            @php
                                $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
                                $price = $ratePlans[0]['price_per_night'] ?? 0;
                            @endphp
                            <option value="{{ $room->id }}">{{ $room->name }} - Rp {{ number_format($price, 0, ',', '.') }}/night</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Check In</label>
                        <input type="date" name="check_in" required class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Check Out</label>
                        <input type="date" name="check_out" required class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none [color-scheme:dark]">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Booking Status</label>
                    <select name="status" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        <option value="confirmed">Confirmed</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="pt-6 border-t border-gray-700 flex justify-end">
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-bold transition shadow-lg">
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
