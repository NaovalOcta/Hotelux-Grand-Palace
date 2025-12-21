<?php

use Illuminate\Support\Facades\Route;
use App\Models\RoomType;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
