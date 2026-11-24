<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kendaraan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'nomor_polisi',
        'merek',
        'tipe',
        'tahun',
        'warna',
        'catatan',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}