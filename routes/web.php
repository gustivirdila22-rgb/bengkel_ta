
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredWorkshopController;

// Halaman utama
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Dashboard / Beranda
Route::get('/dashboard', function () {
    return Inertia::render('Beranda');
})->name('dashboard');

// Login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Logout
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth');

// Register
Route::get('/register', [RegisteredWorkshopController::class, 'create']);
Route::post('/register', [RegisteredWorkshopController::class, 'store']);
