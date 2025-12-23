<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    // Tampilkan daftar kamar
    public function index()
    {
        $rooms = RoomType::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    // Tampilkan form tambah kamar
    public function create()
    {
        return view('admin.rooms.create');
    }

    // Simpan kamar baru
    public function store(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'id' => 'required|string|unique:room_types,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric',
            'size_m2' => 'required|integer',
            'total_inventory' => 'required|integer',
            'view_type' => 'required|string',
            'bed_type' => 'required|string',
            'max_adults' => 'required|integer',
            'max_children' => 'required|integer',
            'amenities_input' => 'nullable|string',
            // VALIDASI GAMBAR DIPERKETAT
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB per file
        ], [
            // PESAN ERROR KHUSUS
            'images.*.image' => 'File yang diupload harus berupa gambar.',
            'images.*.mimes' => 'Format gambar salah! Hanya diperbolehkan: JPG, JPEG, PNG, dan WEBP.',
            'images.*.max' => 'Ukuran gambar terlalu besar! Maksimal 2MB per foto.',
        ]);

        // 2. PROSES AMENITIES (String to Array)
        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];

        // 3. ALGORITMA UPLOAD GAMBAR (PENTING!)
        $galleryImages = [];

        // Cek apakah ada file yang diupload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Simpan file ke folder 'storage/app/public/rooms'
                // method store() mengembalikan path file (misal: rooms/namafile.jpg)
                $path = $file->store('rooms', 'public');
                $galleryImages[] = $path;
            }
        }

        // 4. STRUKTUR RATE PLANS
        $ratePlans = [[
            'name' => 'Standard Rate',
            'price_per_night' => (int)$request->price_per_night,
            'is_refundable' => true,
            'includes_breakfast' => true
        ]];

        // 5. SIMPAN KE DATABASE
        RoomType::create([
            'id' => Str::slug($request->id),
            'name' => $request->name,
            'description' => $request->description,
            'size_m2' => $request->size_m2,
            'view_type' => $request->view_type,
            'bed_type' => $request->bed_type,
            'total_inventory' => $request->total_inventory,
            'occupancy' => [
                'max_adults' => (int)$request->max_adults,
                'max_children' => (int)$request->max_children
            ],
            'amenities' => $amenities,
            'gallery_images' => $galleryImages,
            'rate_plans' => $ratePlans
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $room = RoomType::findOrFail($id);

        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
        $price = $ratePlans[0]['price_per_night'] ?? 0;

        $amenities = is_string($room->amenities) ? json_decode($room->amenities, true) : $room->amenities;
        // Pastikan array sebelum di-implode
        $amenitiesString = implode(', ', is_array($amenities) ? $amenities : []);

        // PERBAIKAN DI SINI:
        $currentImages = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;

        // Paksa jadi array kosong jika hasil decode null/bukan array
        if (!is_array($currentImages)) {
            $currentImages = [];
        }

        $occupancy = is_string($room->occupancy) ? json_decode($room->occupancy, true) : $room->occupancy;

        return view('admin.rooms.edit', compact('room', 'price', 'amenitiesString', 'currentImages', 'occupancy'));
    }

    // Update kamar
    public function update(Request $request, $id)
    {
        $room = RoomType::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'price_per_night' => 'required|numeric',
            // Gunakan 'nullable' agar tidak wajib upload gambar saat edit
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 1. Ambil Gambar Lama (Handle jika data database null/string/array)
        $existingImages = $room->gallery_images;

        // Jika karena suatu alasan formatnya string JSON, decode dulu
        if (is_string($existingImages)) {
            $existingImages = json_decode($existingImages, true);
        }
        // Pastikan selalu array
        if (!is_array($existingImages)) {
            $existingImages = [];
        }

        // 2. Filter Gambar yang Dihapus
        $imagesToDelete = $request->input('delete_images', []);
        $keptImages = [];

        foreach ($existingImages as $img) {
            if (in_array($img, $imagesToDelete)) {
                // Hapus file dari penyimpanan jika itu file lokal (bukan URL)
                if (!filter_var($img, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($img);
                }
            } else {
                $keptImages[] = $img;
            }
        }

        // 3. Tambah Gambar Baru (Jika ada upload)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Simpan dan ambil path-nya
                $path = $file->store('rooms', 'public');
                $keptImages[] = $path;
            }
        }

        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];
        $ratePlans = [[
            'name' => 'Standard Rate',
            'price_per_night' => (int)$request->price_per_night,
            'is_refundable' => true,
            'includes_breakfast' => true
        ]];

        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'size_m2' => $request->size_m2,
            'view_type' => $request->view_type,
            'bed_type' => $request->bed_type,
            'total_inventory' => $request->total_inventory,
            'occupancy' => [
                'max_adults' => (int)$request->max_adults,
                'max_children' => (int)$request->max_children
            ],
            'amenities' => $amenities,
            'gallery_images' => $keptImages, // Array final (Sisa lama + Baru)
            'rate_plans' => $ratePlans
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    // Hapus kamar
    public function destroy($id)
    {
        $room = RoomType::findOrFail($id);
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
