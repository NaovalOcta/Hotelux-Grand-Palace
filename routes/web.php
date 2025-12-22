<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES (Guest & User) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms.index');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities.index');

// Contact Routes
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// --- AUTHENTICATION ROUTES ---
// Login Page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Register Page
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');


// --- ADMIN ROUTES (Protected) ---
// Hanya bisa diakses jika Login & Role = Admin
Route::middleware(['auth:web', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Rooms (Manage Kamar)
        // Ini otomatis membuat route: admin.rooms.index, create, store, edit, update, destroy
        Route::resource('rooms', AdminRoomController::class);

        // CRUD Bookings (Manage Pemesanan)
        Route::resource('bookings', AdminBookingController::class);
    });

// --- USER ROUTES (Protected) ---
// Fitur khusus user yang sudah login
Route::middleware(['auth:web', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/my-bookings', function () {
        return view('user.bookings'); // Pastikan view ini ada atau ganti return string dulu
    })->name('user.bookings');
});
