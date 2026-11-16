<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Buka halaman utama langsung ke Beranda
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Rute saat menu "Beranda" di sidebar diklik
Route::get('/dashboard', function () {
    return Inertia::render('Beranda');
})->name('dashboard');