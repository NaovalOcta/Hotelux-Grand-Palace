<?php

use Illuminate\Support\Facades\Route;
use App\Models\RoomType;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
