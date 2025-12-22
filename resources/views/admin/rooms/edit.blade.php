@extends('layouts.app')

@section('title', 'Edit Room')

@section('content')
    <div class="pt-32 pb-20 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6 max-w-4xl">

            <div class="mb-8">
                <a href="{{ route('admin.rooms.index') }}"
                    class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1 transition">
                    <span class="material-icons-outlined text-sm">arrow_back</span> Back to List
                </a>
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Edit Room: {{ $room->name }}</h1>
                    <span class="bg-gray-800 text-gray-400 px-3 py-1 rounded text-sm font-mono">{{ $room->id }}</span>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl border border-gray-700 p-8 shadow-xl">
                <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Room Name</label>
                        <input type="text" name="name" value="{{ $room->name }}"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">{{ $room->description }}</textarea>
                    </div>

                    {{-- Specs --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rp)</label>
                            <input type="number" name="price_per_night" value="{{ $price }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Size (m²)</label>
                            <input type="number" name="size_m2" value="{{ $room->size_m2 }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Total Inventory</label>
                            <input type="number" name="total_inventory" value="{{ $room->total_inventory }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">View Type</label>
                            <input type="text" name="view_type" value="{{ $room->view_type }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Bed Type</label>
                            <input type="text" name="bed_type" value="{{ $room->bed_type }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    {{-- Occupancy --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Max Adults</label>
                            <input type="number" name="max_adults" value="{{ $occupancy['max_adults'] ?? 2 }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Max Children</label>
                            <input type="number" name="max_children" value="{{ $occupancy['max_children'] ?? 1 }}"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    {{-- Arrays --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Amenities (Comma separated)</label>
                        <input type="text" name="amenities_input" value="{{ $amenitiesString }}"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Image URLs (Comma separated)</label>
                        <textarea name="images_input" rows="3"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">{{ $imagesString }}</textarea>
                    </div>

                    <div class="pt-6 border-t border-gray-700 flex justify-end">
                        <button type="submit"
                            class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-bold transition shadow-lg">
                            Update Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
