<?php

namespace App\Http\Controllers;

use App\Models\KategoriJasa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriJasaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_jasa,nama'],
            'aktif' => ['boolean'],
        ]);

        $validated['kode_kategori'] = 'KJS-' . str_pad(
            (KategoriJasa::max('id') ?? 0) + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        $validated['aktif'] = $validated['aktif'] ?? true;

        KategoriJasa::create($validated);

        return back()->with('success', 'Kategori jasa berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriJasa $kategoriJasa)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_jasa', 'nama')->ignore($kategoriJasa->id),
            ],
            'aktif' => ['required', 'boolean'],
        ]);

        $kategoriJasa->update($validated);

        return back()->with('success', 'Kategori jasa berhasil diperbarui.');
    }

    public function destroy(KategoriJasa $kategoriJasa)
    {
        $kategoriJasa->delete();

        return back()->with('success', 'Kategori jasa berhasil dihapus.');
    }
}