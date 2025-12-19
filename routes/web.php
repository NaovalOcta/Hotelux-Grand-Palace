<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/rooms', function () {
    return view('rooms.index');
})->name('rooms');
