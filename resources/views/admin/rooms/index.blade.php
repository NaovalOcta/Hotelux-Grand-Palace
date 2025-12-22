@extends('layouts.app')

@section('title', 'Manage Rooms')

@section('content')
    <div class="pt-32 pb-12 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Manage Rooms</h1>
                    <p class="text-gray-400">Create, update, or remove room types.</p>
                </div>
                <a href="{{ route('admin.rooms.create') }}"
                    class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-bold transition flex items-center gap-2">
                    <span class="material-icons-outlined">add</span>
                    Add New Room
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-400">
                        <thead class="bg-gray-900/50 text-xs uppercase font-medium text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Price / Night</th>
                                <th class="px-6 py-4">Size</th>
                                <th class="px-6 py-4">Inventory</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($rooms as $room)
                                @php
                                    $ratePlans = is_string($room->rate_plans)
                                        ? json_decode($room->rate_plans, true)
                                        : $room->rate_plans;
                                    $price = $ratePlans[0]['price_per_night'] ?? 0;
                                @endphp
                                <tr class="hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-white font-bold">{{ $room->name }}</div>
                                            <span class="text-xs bg-gray-700 px-2 py-1 rounded">{{ $room->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-amber-500 font-medium">
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $room->size_m2 }} m²</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 rounded text-xs {{ $room->total_inventory > 0 ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                            {{ $room->total_inventory }} Units
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                class="p-2 text-blue-400 hover:bg-blue-400/10 rounded transition"
                                                title="Edit">
                                                <span class="material-icons-outlined text-base">edit</span>
                                            </a>
                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this room?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-400 hover:bg-red-400/10 rounded transition"
                                                    title="Delete">
                                                    <span class="material-icons-outlined text-base">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
