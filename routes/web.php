<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES (Guest) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms.index');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// --- AUTH ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- USER ROUTES (Authenticated User) ---
Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    // Route untuk proses booking (nanti dibuat di BookingController)
    // Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Halaman khusus user profile (opsional)
    Route::get('/my-bookings', function () {
        return "Halaman Riwayat Booking User";
    })->name('user.bookings');
});

// --- ADMIN ROUTES (Dashboard) ---
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Nanti tambahkan route CRUD rooms, bookings disini
});
