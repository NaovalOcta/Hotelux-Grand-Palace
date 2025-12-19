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
}
