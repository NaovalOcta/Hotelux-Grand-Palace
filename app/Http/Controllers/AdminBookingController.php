<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    // Tampilkan semua booking
    public function index()
    {
        // Mengambil booking dengan relasi user dan roomType agar efisien
        $bookings = Booking::with(['user', 'roomType'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // Form buat booking baru
    public function create()
    {
        $users = User::where('role', 'user')->get(); // Ambil list user tamu
        $rooms = RoomType::all();
        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    // Simpan booking baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        // Hitung Total Harga Otomatis
        $room = RoomType::findOrFail($request->room_type_id);

        // Ambil harga dari JSON rate_plans
        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
        $pricePerNight = $ratePlans[0]['price_per_night'] ?? 0;

        // Hitung durasi malam
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $days = $checkIn->diffInDays($checkOut);

        if ($days < 1) $days = 1; // Minimal 1 malam

        $totalPrice = $pricePerNight * $days;

        Booking::create([
            'user_id' => $request->user_id,
            'room_type_id' => $request->room_type_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => $request->status,
            'guest_name' => User::find($request->user_id)->name, // Simpan nama snapshot
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully!');
    }

    // Form edit booking
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $users = User::all();
        $rooms = RoomType::all();
        return view('admin.bookings.edit', compact('booking', 'users', 'rooms'));
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        // Hitung Ulang Harga (jika kamar/tanggal berubah)
        $room = RoomType::findOrFail($request->room_type_id);

        $ratePlans = is_string($room->rate_plans) ? json_decode($room->rate_plans, true) : $room->rate_plans;
        $pricePerNight = $ratePlans[0]['price_per_night'] ?? 0;

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $days = $checkIn->diffInDays($checkOut);
        if ($days < 1) $days = 1;

        $totalPrice = $pricePerNight * $days;

        $booking->update([
            'room_type_id' => $request->room_type_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }

    // Hapus booking
    public function destroy($id)
    {
        Booking::destroy($id);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
