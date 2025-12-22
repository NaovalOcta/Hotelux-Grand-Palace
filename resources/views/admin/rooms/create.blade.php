@extends('layouts.app')

@section('title', 'Add New Room')

@section('content')
    <div class="pt-32 pb-20 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6 max-w-4xl">

            <div class="mb-8">
                <a href="{{ route('admin.rooms.index') }}"
                    class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1 transition">
                    <span class="material-icons-outlined text-sm">arrow_back</span> Back to List
                </a>
                <h1 class="text-3xl font-bold text-white">Add New Room</h1>
            </div>

            <div class="bg-gray-800 rounded-xl border border-gray-700 p-8 shadow-xl">
                {{-- Tambahkan enctype agar bisa upload file --}}
                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Bagian Input Lainnya (Sama seperti sebelumnya) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Room ID (Slug)</label>
                            <input type="text" name="id" required placeholder="e.g. deluxe-king-suite"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Room Name</label>
                            <input type="text" name="name" required placeholder="e.g. Deluxe King Suite"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <textarea name="description" required rows="4"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rp)</label>
                            <input type="number" name="price_per_night" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Size (m²)</label>
                            <input type="number" name="size_m2" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Total Inventory</label>
                            <input type="number" name="total_inventory" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">View Type</label>
                            <input type="text" name="view_type" required placeholder="e.g. City View"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Bed Type</label>
                            <input type="text" name="bed_type" required placeholder="e.g. King Bed"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Max Adults</label>
                            <input type="number" name="max_adults" value="2"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Max Children</label>
                            <input type="number" name="max_children" value="1"
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Amenities (Comma separated)</label>
                        <input type="text" name="amenities_input" placeholder="Wifi, TV, Pool, Breakfast"
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:outline-none">
                    </div>

                    {{-- CHANGE: From Textarea URL to File Input --}}
                    <div class="bg-gray-700/30 p-4 rounded-lg border border-gray-600 border-dashed">
                        <label class="block text-sm font-medium text-white mb-2">Upload Images</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="block w-full text-sm text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-amber-600 file:text-white
                        file:cursor-pointer hover:file:bg-amber-700
                    " />
                        <p class="text-xs text-gray-500 mt-2">Allowed: JPG, PNG, WEBP. Max: 2MB per file. You can select
                            multiple files.</p>
                    </div>

                    <div class="pt-6 border-t border-gray-700 flex justify-end">
                        <button type="submit"
                            class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-bold transition shadow-lg">
                            Create Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
