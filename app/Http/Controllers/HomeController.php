<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Testimonial;
use App\Models\Promotion;
use App\Models\HotelFacility;
use App\Models\HotelProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua data yang dibutuhkan view
        $hotel = HotelProfile::first(); // Ambil profil hotel utama
        $rooms = RoomType::all(); // Mengambil semua tipe kamar
        $testimonials = Testimonial::all();
        $promotions = Promotion::all();
        $facilities = HotelFacility::all();

        // Pass data ke view 'home'
        return view('home', compact('hotel', 'rooms', 'testimonials', 'promotions', 'facilities'));
    }

    public function rooms()
    {
        $rooms = RoomType::all();
        $hotel = HotelProfile::first();
        return view('rooms.index', compact('rooms', 'hotel'));
    }

    public function facilities()
    {
        $facilities = HotelFacility::all();
        $hotel = HotelProfile::first();
        return view('facilities.index', compact('facilities', 'hotel'));
    }

    public function contact()
    {
        $hotel = HotelProfile::first();
        return view('contact.index', compact('hotel'));
    }

    public function sendContact(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Disini Anda bisa menambahkan logika kirim email (Mail::to...)
        // Untuk sekarang, kita kembalikan pesan sukses saja.

        return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');
    }
}
