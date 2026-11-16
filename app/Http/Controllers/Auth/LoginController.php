<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cari akun berdasarkan email atau nomor HP
        $user = User::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

        // Jika email atau nomor HP tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'login' => 'Email atau nomor WhatsApp tidak terdaftar.',
            ])->onlyInput('login');
        }

        // Jika password salah
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang kamu masukkan salah.',
            ])->onlyInput('login');
        }

        // Login berhasil
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
