@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="pt-32 pb-20 bg-gray-900 min-h-screen">
    <div class="container mx-auto px-6 max-w-4xl">

        <div class="mb-8">
            <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1 transition">
                <span class="material-icons-outlined text-sm">arrow_back</span> Back to List
            </a>
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-white">Edit Booking #{{ $booking->id }}</h1>
                <span class="bg-gray-800 text-gray-400 px-3 py-1 rounded text-sm font-mono">{{ $booking->guest_name }}</span>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-gray-700 p-8 shadow-xl">
            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Room Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Room Type</label>
                    <select name="room_type_id" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        @foreach($rooms as $room)
                            @php
                                $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
                                $price = $ratePlans[0]['price_per_night'] ?? 0;
                            @endphp
                            <option value="{{ $room->id }}" {{ $booking->room_type_id == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} - Rp {{ number_format($price, 0, ',', '.') }}/night
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Check In</label>
                        <input type="date" name="check_in" value="{{ $booking->check_in }}" required class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Check Out</label>
                        <input type="date" name="check_out" value="{{ $booking->check_out }}" required class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none [color-scheme:dark]">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Booking Status</label>
                    <select name="status" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="bg-gray-900/50 p-4 rounded-lg border border-gray-700/50 text-sm text-gray-400">
                    <span class="text-amber-500 font-bold">Note:</span> Changing dates or room type will automatically recalculate the total price.
                </div>

                <div class="pt-6 border-t border-gray-700 flex justify-end">
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-bold transition shadow-lg">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
