
<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredWorkshopController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\JasaServisController;
use App\Http\Controllers\KategoriJasaController;

// ========================================
// HALAMAN UTAMA
// ========================================

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// ========================================
// DASHBOARD
// ========================================

Route::get('/dashboard', function () {
    return Inertia::render('Beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========================================
// LOGIN & LOGOUT
// ========================================

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth');

// ========================================
// REGISTER
// ========================================

Route::get('/register', [RegisteredWorkshopController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredWorkshopController::class, 'store']);

// ========================================
// KASIR CEPAT
// ========================================

Route::get('/kasir', function () {
    return Inertia::render('KasirCepat');
})->name('kasir');

// ========================================
// TRANSAKSI SERVIS
// ========================================

Route::get('/servis', function () {
    return Inertia::render('Servis');
})->name('servis');

Route::get('/servis/tambah', function () {
    return Inertia::render('TambahServis');
})->name('servis.tambah');

// ========================================
// PELANGGAN & KENDARAAN
// ========================================

Route::resource('pelanggan', PelangganController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::resource('kendaraan', KendaraanController::class)
    ->only(['store', 'update', 'destroy']);

// ========================================
// MASTER JASA SERVIS
// ========================================

Route::get('/jasa-servis', [JasaServisController::class, 'index'])
    ->name('jasa-servis.index');

Route::get('/jasa-servis/create', [JasaServisController::class, 'create'])
    ->name('jasa-servis.create');

Route::post('/jasa-servis', [JasaServisController::class, 'store'])
    ->name('jasa-servis.store');

Route::get('/jasa-servis/{jasaServi}/edit', [JasaServisController::class, 'edit'])
    ->name('jasa-servis.edit');

Route::put('/jasa-servis/{jasaServi}', [JasaServisController::class, 'update'])
    ->name('jasa-servis.update');

Route::delete('/jasa-servis/{jasaServi}', [JasaServisController::class, 'destroy'])
    ->name('jasa-servis.destroy');

// ========================================
// KATEGORI JASA
// ========================================

Route::post('/kategori-jasa', [KategoriJasaController::class, 'store'])
    ->name('kategori-jasa.store');

Route::put('/kategori-jasa/{kategoriJasa}', [KategoriJasaController::class, 'update'])
    ->name('kategori-jasa.update');

Route::delete('/kategori-jasa/{kategoriJasa}', [KategoriJasaController::class, 'destroy'])
    ->name('kategori-jasa.destroy');

// ========================================
// VERIFIKASI EMAIL
// ========================================

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail', [
        'status' => session('status'),
    ]);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
