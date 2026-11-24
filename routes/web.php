<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredWorkshopController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;

// Halaman utama
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Dashboard / Beranda (Wajib login & sudah verifikasi email)
Route::get('/dashboard', function () {
    return Inertia::render('Beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

// Login & Logout
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');

// Register
Route::get('/register', [RegisteredWorkshopController::class, 'create'])->name('register');
Route::post('/register', [RegisteredWorkshopController::class, 'store']);

// Kasir cepat
Route::get('/kasir', function () {
    return Inertia::render('KasirCepat');
})->name('kasir');

// Servis
Route::get('/servis', function () {
    return Inertia::render('Servis');
})->name('servis');

// Tambah servis
Route::get('/servis/tambah', function () {
    return Inertia::render('TambahServis');
})->name('servis.tambah');

// --- RUTE VERIFIKASI EMAIL ---
// 1. Halaman pemberitahuan "Silakan cek email"
Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail', [
        'status' => session('status'),
    ]);
})->middleware('auth')->name('verification.notice');

// 2. Handler saat link verifikasi di dalam email diklik
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 3. Tombol kirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//pelanggan & kendaraan
Route::resource('pelanggan', PelangganController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::resource('kendaraan', KendaraanController::class)
    ->only(['store', 'update', 'destroy']);


