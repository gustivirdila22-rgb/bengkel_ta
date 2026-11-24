<?php

namespace Tests\Feature;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_without_vehicles_can_be_deleted(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Tanpa Kendaraan',
            'tingkat_harga' => 'Umum',
            'aktif' => true,
        ]);

        $this->from('/pelanggan')
            ->delete('/pelanggan/' . $pelanggan->id)
            ->assertRedirect('/pelanggan');

        $this->assertDatabaseMissing('pelanggans', [
            'id' => $pelanggan->id,
        ]);
    }

    public function test_customer_with_vehicles_cannot_be_deleted(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Dengan Kendaraan',
            'tingkat_harga' => 'Umum',
            'aktif' => true,
        ]);

        Kendaraan::create([
            'pelanggan_id' => $pelanggan->id,
            'nomor_polisi' => 'B 1234 XYZ',
        ]);

        $this->from('/pelanggan')
            ->delete('/pelanggan/' . $pelanggan->id)
            ->assertRedirect('/pelanggan')
            ->assertSessionHasErrors('delete');

        $this->assertDatabaseHas('pelanggans', [
            'id' => $pelanggan->id,
        ]);
    }
}
