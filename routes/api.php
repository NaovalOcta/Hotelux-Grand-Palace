<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\RoleMiddleware;

// --- AUTH GROUP ---
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// --- PUBLIC DATA (GUEST) ---
// Bisa diakses tanpa token
Route::get('/rooms', [HomeController::class, 'rooms']); // Anggap HomeController diubah return JSON
Route::get('/facilities', [HomeController::class, 'facilities']);

// --- USER FEATURES (BOOKING) ---
// Hanya bisa diakses jika punya Token Valid dan Role = User
Route::middleware(['auth:api', RoleMiddleware::class . ':user'])->group(function () {
    Route::post('/booking', function () {
        // Logika booking disini (simulasi)
        return response()->json(['message' => 'Booking successful!', 'data' => request()->all()]);
    });

    Route::get('/my-bookings', function () {
        return response()->json(['message' => 'List of my bookings']);
    });
});

// --- ADMIN FEATURES (DASHBOARD) ---
// Hanya bisa diakses jika punya Token Valid dan Role = Admin
Route::middleware(['auth:api', RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {

    // Dashboard data
    Route::get('/dashboard', [AdminController::class, 'dashboard']); // Pastikan AdminController return JSON

    // CRUD Operations (Contoh)
    Route::post('/rooms', function () {
        return response()->json(['msg' => 'Room created']);
    });
    Route::delete('/rooms/{id}', function () {
        return response()->json(['msg' => 'Room deleted']);
    });
});
