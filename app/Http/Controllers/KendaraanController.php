<?php

namespace App\Http\Controllers;


use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        return redirect()->route('pelanggan.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggans,id'],
            'nomor_polisi' => ['required', 'string', 'max:20', 'unique:kendaraans,nomor_polisi'],
            'merek' => ['nullable', 'string', 'max:100'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'warna' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ]);

        $validated['nomor_polisi'] = strtoupper($validated['nomor_polisi']);

        Kendaraan::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggans,id'],
            'nomor_polisi' => [
                'required',
                'string',
                'max:20',
                'unique:kendaraans,nomor_polisi,' . $kendaraan->id,
            ],
            'merek' => ['nullable', 'string', 'max:100'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'warna' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ]);

        $validated['nomor_polisi'] = strtoupper($validated['nomor_polisi']);

        $kendaraan->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()
            ->back()
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}