<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'tingkat_harga',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function kendaraans(): HasMany
    {
        return $this->hasMany(Kendaraan::class);
    }
}