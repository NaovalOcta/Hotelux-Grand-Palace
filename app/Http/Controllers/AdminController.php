<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\RoomType;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data ringkas untuk statistik
        $stats = [
            'total_bookings' => Booking::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_rooms' => RoomType::sum('total_inventory'),
            'revenue' => Booking::sum('total_price'),
            'recent_bookings' => Booking::with('roomType')->latest()->take(5)->get()
        ];

        // LOGIKA PERBAIKAN:
        // Jika request minta JSON (API), kirim JSON.
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $stats
            ]);
        }

        // Jika akses biasa (Browser/Menu Profile), tampilkan View Dashboard
        return view('admin.dashboard', compact('stats'));
    }
}
