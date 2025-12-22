<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = RoomType::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi file gambar
        ]);

        // 1. Handle Amenities
        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];

        // 2. Handle Image Upload
        $galleryImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Simpan ke storage/app/public/rooms
                $path = $file->store('rooms', 'public');
                $galleryImages[] = $path;
            }
        }

        // 3. Rate Plans
        $ratePlans = [[
            'name' => 'Standard Rate',
            'price_per_night' => (int)$request->price_per_night,
            'is_refundable' => true,
            'includes_breakfast' => true
        ]];

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
            'gallery_images' => $galleryImages, // Simpan array path
            'rate_plans' => $ratePlans
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    public function edit($id)
    {
        $room = RoomType::findOrFail($id);

        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
        $price = $ratePlans[0]['price_per_night'] ?? 0;

        $amenities = is_string($room->amenities) ? json_decode($room->amenities, true) : $room->amenities;
        $amenitiesString = implode(', ', $amenities ?? []);

        // Ambil gambar yang sudah ada
        $currentImages = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;
        if (!is_array($currentImages)) $currentImages = [];

        $occupancy = is_string($room->occupancy) ? json_decode($room->occupancy, true) : $room->occupancy;

        return view('admin.rooms.edit', compact('room', 'price', 'amenitiesString', 'currentImages', 'occupancy'));
    }

    public function update(Request $request, $id)
    {
        $room = RoomType::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'price_per_night' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 1. Handle Amenities
        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];

        // 2. Handle Images Logic (Keep Old + Add New - Deleted)

        // Ambil gambar lama dari database
        $existingImages = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;
        if (!is_array($existingImages)) $existingImages = [];

        // Cek gambar mana yang ingin dihapus user (dari checkbox di view)
        $imagesToDelete = $request->input('delete_images', []);

        // Hapus file fisik dan hapus dari array
        $keptImages = [];
        foreach ($existingImages as $img) {
            if (in_array($img, $imagesToDelete)) {
                Storage::disk('public')->delete($img); // Hapus file fisik
            } else {
                $keptImages[] = $img; // Simpan jika tidak dicentang hapus
            }
        }

        // Upload gambar baru (Append)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('rooms', 'public');
                $keptImages[] = $path;
            }
        }

        // 3. Update Rate Plans
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
            'gallery_images' => $keptImages, // Simpan array hasil gabungan
            'rate_plans' => $ratePlans
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = RoomType::findOrFail($id);

        // Hapus file gambar terkait saat room dihapus
        $images = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;
        if (is_array($images)) {
            foreach ($images as $img) {
                // Cek agar tidak menghapus gambar URL eksternal (jika ada sisa data lama)
                if (!filter_var($img, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
