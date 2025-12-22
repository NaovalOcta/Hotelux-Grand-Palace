<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $validated = $request->validate([
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
            'amenities_input' => 'nullable|string', // Input string dipisahkan koma
            'images_input' => 'nullable|string',    // Input URL dipisahkan koma
        ]);

        // Proses data untuk format JSON
        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];
        $images = $request->images_input ? array_map('trim', explode(',', $request->images_input)) : [];

        // Struktur Rate Plans sederhana
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
            'gallery_images' => $images,
            'rate_plans' => $ratePlans
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $room = RoomType::findOrFail($id);

        // Ekstrak data untuk ditampilkan di form
        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
        $price = $ratePlans[0]['price_per_night'] ?? 0;

        $amenities = is_string($room->amenities) ? json_decode($room->amenities, true) : $room->amenities;
        $amenitiesString = implode(', ', $amenities ?? []);

        $images = is_string($room->gallery_images) ? json_decode($room->gallery_images, true) : $room->gallery_images;
        $imagesString = implode(', ', $images ?? []);

        $occupancy = is_string($room->occupancy) ? json_decode($room->occupancy, true) : $room->occupancy;

        return view('admin.rooms.edit', compact('room', 'price', 'amenitiesString', 'imagesString', 'occupancy'));
    }

    // Update kamar
    public function update(Request $request, $id)
    {
        $room = RoomType::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'price_per_night' => 'required|numeric',
        ]);

        // Proses ulang array
        $amenities = $request->amenities_input ? array_map('trim', explode(',', $request->amenities_input)) : [];
        $images = $request->images_input ? array_map('trim', explode(',', $request->images_input)) : [];

        // Update Rate Plans
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
            'gallery_images' => $images,
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
