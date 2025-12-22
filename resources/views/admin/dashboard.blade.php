@extends('layouts.app')

@section('title', 'Admin Dashboard - Hotelux')

@section('content')
    <div class="pt-32 pb-20 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6">

            {{-- Admin Header --}}
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard</h1>
                    <p class="text-gray-400">Welcome back, Administrator.</p>
                </div>
                <div class="flex gap-4">
                    {{-- Placeholder tombol aksi --}}
                    <a href="{{ route('admin.rooms.index') }}"
                        class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition border border-gray-700 flex items-center gap-2">
                        <span class="material-icons-outlined text-sm">bed</span>
                        Manage Rooms
                    </a>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition border border-gray-700 flex items-center gap-2">
                        <span class="material-icons-outlined text-sm">book_online</span>
                        Manage Bookings
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Total Bookings</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['total_bookings'] }}</h3>
                        </div>
                        <div class="bg-amber-600/20 p-2 rounded-lg text-amber-500">
                            <span class="material-icons-outlined">book_online</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Registered Users</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="bg-blue-600/20 p-2 rounded-lg text-blue-500">
                            <span class="material-icons-outlined">people</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Total Revenue</p>
                            <h3 class="text-3xl font-bold text-white">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-green-600/20 p-2 rounded-lg text-green-500">
                            <span class="material-icons-outlined">payments</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Rooms Available</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['total_rooms'] }}</h3>
                        </div>
                        <div class="bg-purple-600/20 p-2 rounded-lg text-purple-500">
                            <span class="material-icons-outlined">bedroom_parent</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Bookings Table --}}
            <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white">Recent Bookings</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-400">
                        <thead class="bg-gray-900/50 text-xs uppercase font-medium text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Guest</th>
                                <th class="px-6 py-4">Room Type</th>
                                <th class="px-6 py-4">Check In</th>
                                <th class="px-6 py-4">Check Out</th>
                                <th class="px-6 py-4">Total Price</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @forelse($stats['recent_bookings'] as $booking)
                                <tr class="hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4 text-white font-medium">{{ $booking->guest_name }}</td>
                                    <td class="px-6 py-4">{{ $booking->roomType->name ?? 'Unknown Room' }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-amber-500 font-bold">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 bg-green-500/10 text-green-500 rounded text-xs">Confirmed</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center italic">No bookings found yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
