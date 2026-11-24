<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::withCount('kendaraans')
            ->latest()
            ->get();

        $kendaraans = \App\Models\Kendaraan::with('pelanggan')
            ->latest()
            ->get();

        return Inertia::render('Pelanggan', [
            'pelanggans' => $pelanggans,
            'kendaraans' => $kendaraans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'tingkat_harga' => [
            'required',
            'in:Umum,Grosir,Distributor',
            ],
            'aktif' => ['required', 'boolean'],
        ]);

        Pelanggan::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'tingkat_harga' => [
            'required',
            'in:Umum,Grosir,Distributor',
            ],
            'aktif' => ['required', 'boolean'],
        ]);

        $pelanggan->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->kendaraans()->exists()) {
            return redirect()->back()->withErrors([
                'delete' => 'Pelanggan tidak bisa dihapus karena masih memiliki kendaraan.',
            ]);
        }

        $pelanggan->delete();

        return redirect()
            ->back()
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}