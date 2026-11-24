<?php

namespace App\Http\Controllers;
use App\Models\JasaServis;
use App\Models\KategoriJasa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JasaServisController extends Controller
{
    public function index()
    {
        $jasaServis = JasaServis::with('kategori')
            ->latest()
            ->get();

        $kategoriJasa = KategoriJasa::withCount('jasaServis')
            ->orderBy('nama')
            ->get();

        return Inertia::render('JasaServis', [
            'jasaServis' => $jasaServis,
            'kategoriJasa' => $kategoriJasa,
            'ringkasan' => [
                'total' => JasaServis::count(),
                'aktif' => JasaServis::where('aktif', true)->count(),
                'nonaktif' => JasaServis::where('aktif', false)->count(),
                'totalKategori' => KategoriJasa::count(),
                'kategoriDipakai' => KategoriJasa::has('jasaServis')->count(),
            ],
        ]);
    }

    // HALAMAN TAMBAH JASA
    public function create()
    {
        return Inertia::render('TambahJasaServis', [
            'kategoriJasa' => KategoriJasa::orderBy('nama')->get(),
        ]);
    }

    // SIMPAN JASA BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori_jasa_id' => [
                'nullable',
                'exists:kategori_jasa,id',
            ],
            'estimasi_menit' => ['nullable', 'integer', 'min:1'],
            'harga_standar' => ['required', 'integer', 'min:0'],
            'modal' => ['nullable', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'aktif' => ['boolean'],
        ]);

        $validated['kode_jasa'] = 'JS-' . str_pad(
            (JasaServis::max('id') ?? 0) + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        $validated['modal'] = $validated['modal'] ?? 0;
        $validated['aktif'] = $validated['aktif'] ?? true;

        JasaServis::create($validated);

        return redirect()
            ->route('jasa-servis.index')
            ->with('success', 'Jasa servis berhasil ditambahkan.');
    }

    // HALAMAN EDIT JASA
    public function edit(JasaServis $jasaServi)
    {
        return Inertia::render('EditJasaServis', [
            'jasa' => $jasaServi,
            'kategoriJasa' => KategoriJasa::orderBy('nama')->get(),
        ]);
    }

    // UPDATE JASA
    public function update(Request $request, JasaServis $jasaServi)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori_jasa_id' => [
                'nullable',
                'exists:kategori_jasa,id',
            ],
            'estimasi_menit' => ['nullable', 'integer', 'min:1'],
            'harga_standar' => ['required', 'integer', 'min:0'],
            'modal' => ['nullable', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'aktif' => ['required', 'boolean'],
        ]);

        $jasaServi->update($validated);

        return redirect()
            ->route('jasa-servis.index')
            ->with('success', 'Jasa servis berhasil diperbarui.');
    }

    // HAPUS JASA
    public function destroy(JasaServis $jasaServi)
    {
        $jasaServi->delete();

        return back()->with('success', 'Jasa servis berhasil dihapus.');
    }
}