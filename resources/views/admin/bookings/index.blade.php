@extends('layouts.app')

@section('title', 'Manage Bookings')

@section('content')
<div class="pt-32 pb-12 bg-gray-900 min-h-screen">
    <div class="container mx-auto px-6">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Manage Bookings</h1>
                <p class="text-gray-400">Track and manage guest reservations.</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-bold transition flex items-center gap-2">
                <span class="material-icons-outlined">add</span>
                New Reservation
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <span class="material-icons-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400">
                    <thead class="bg-gray-900/50 text-xs uppercase font-medium text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Guest Info</th>
                            <th class="px-6 py-4">Room Type</th>
                            <th class="px-6 py-4">Dates</th>
                            <th class="px-6 py-4">Total Price</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="px-6 py-4">
                                    <div class="text-white font-bold">{{ $booking->guest_name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $booking->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-700 text-gray-300 px-2 py-1 rounded text-sm">
                                        {{ $booking->roomType->name ?? 'Unknown Room' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center gap-1 text-gray-300">
                                        <span class="material-icons-outlined text-xs">login</span>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-500 mt-1">
                                        <span class="material-icons-outlined text-xs">logout</span>
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-amber-500 font-bold font-mono">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($booking->status) {
                                            'confirmed' => 'text-green-500 bg-green-500/10 border-green-500/20',
                                            'pending' => 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20',
                                            'cancelled' => 'text-red-500 bg-red-500/10 border-red-500/20',
                                            'completed' => 'text-blue-500 bg-blue-500/10 border-blue-500/20',
                                            default => 'text-gray-500 bg-gray-500/10',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border uppercase {{ $statusColor }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white rounded-lg transition" title="Edit">
                                            <span class="material-icons-outlined text-sm">edit</span>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Delete this booking?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Delete">
                                                <span class="material-icons-outlined text-sm">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                    No bookings found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
