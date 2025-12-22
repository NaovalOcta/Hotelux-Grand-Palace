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
                <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Input Fields yang sama seperti Create (Name, Desc, Price, dll) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Room Name</label>
                        <input type="text" name="name" value="{{ $room->name }}"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">{{ $room->description }}</textarea>
                    </div>

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

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Amenities (Comma separated)</label>
                        <input type="text" name="amenities_input" value="{{ $amenitiesString }}"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                    </div>

                    {{-- CHANGE: Manage Images --}}
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-400">Manage Gallery Images</label>

                        {{-- 1. Show Current Images --}}
                        @if (count($currentImages) > 0)
                            <div
                                class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-900 p-4 rounded-lg border border-gray-700">
                                @foreach ($currentImages as $img)
                                    <div class="relative group">
                                        {{-- Cek apakah URL eksternal atau lokal storage --}}
                                        @php
                                            $isUrl = filter_var($img, FILTER_VALIDATE_URL);
                                            $src = $isUrl ? $img : asset('storage/' . $img);
                                        @endphp
                                        <img src="{{ $src }}"
                                            class="w-full h-24 object-cover rounded border border-gray-600">

                                        {{-- Checkbox untuk menghapus --}}
                                        <div class="absolute top-1 right-1">
                                            <input type="checkbox" name="delete_images[]" value="{{ $img }}"
                                                class="w-5 h-5 text-red-600 bg-gray-800 border-gray-600 rounded focus:ring-red-500 cursor-pointer">
                                        </div>
                                        <div
                                            class="absolute bottom-0 left-0 w-full bg-black/70 text-white text-xs text-center py-1 opacity-0 group-hover:opacity-100 transition">
                                            Tick to delete
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">No images available.</p>
                        @endif

                        {{-- 2. Upload New Images --}}
                        <div class="bg-gray-700/30 p-4 rounded-lg border border-gray-600 border-dashed">
                            <label class="block text-sm font-medium text-white mb-2">Upload New Images</label>
                            <input type="file" name="images[]" multiple accept="image/*"
                                class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-amber-600 file:text-white
                            file:cursor-pointer hover:file:bg-amber-700
                        " />
                            <p class="text-xs text-gray-500 mt-2">New images will be added to the gallery. To remove old
                                ones, check the boxes above.</p>
                        </div>
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
