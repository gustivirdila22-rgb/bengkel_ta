<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return Inertia::render('Supplier', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Supplier/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => ['required', 'string', 'max:255'],
            'nama_kontak' => ['nullable', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'tempo_bayar' => ['nullable', 'integer', 'min:0'],
            'lama_pengiriman' => ['nullable', 'integer', 'min:0'],
            'nama_bank' => ['nullable', 'string', 'max:100'],
            'nomor_rekening' => ['nullable', 'string', 'max:100'],
            'atas_nama' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);

        $supplier = DB::transaction(function () use ($request, $validated) {
            $user = $request->user();

            $jumlahSupplier = Supplier::where('user_id', $user->id)
                ->lockForUpdate()
                ->count();

            $kodeSupplier = 'SUP-' . str_pad(
                $jumlahSupplier + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            return Supplier::create([
                ...$validated,
                'user_id' => $user->id,
                'kode_supplier' => $kodeSupplier,
            ]);
        });

        if ($request->input('aksi') === 'tambah_lagi') {
        return redirect()
            ->route('supplier.create')
            ->with('success', 'Supplier berhasil ditambahkan.');
        }

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }
    public function destroy(Request $request, Supplier $supplier)
    {
        abort_unless(
            $supplier->user_id === $request->user()->id,
            403
        );

        $supplier->delete();

        return back()->with('success', 'Supplier berhasil dihapus.');
    }
    public function edit(Request $request, Supplier $supplier)
{
    abort_unless(
        (int) $supplier->user_id === (int) $request->user()->id,
        403
    );

    return Inertia::render('Supplier/Edit', [
        'supplier' => $supplier,
    ]);
}

public function update(Request $request, Supplier $supplier)
{
    abort_unless(
        (int) $supplier->user_id === (int) $request->user()->id,
        403
    );

    $validated = $request->validate([
        'nama_supplier' => ['required', 'string', 'max:255'],
        'nama_kontak' => ['nullable', 'string', 'max:255'],
        'telepon' => ['nullable', 'string', 'max:30'],
        'alamat' => ['nullable', 'string'],
        'tempo_bayar' => ['nullable', 'integer', 'min:0'],
        'lama_pengiriman' => ['nullable', 'integer', 'min:0'],
        'nama_bank' => ['nullable', 'string', 'max:100'],
        'nomor_rekening' => ['nullable', 'string', 'max:100'],
        'atas_nama' => ['nullable', 'string', 'max:255'],
        'catatan' => ['nullable', 'string'],
    ]);

    $supplier->update($validated);

    return redirect()
        ->route('supplier.index')
        ->with('success', 'Supplier berhasil diperbarui.');
}
}
