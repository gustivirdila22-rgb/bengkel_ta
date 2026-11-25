<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    protected $fillable = [
        'user_id',
        'kode_supplier',
        'nama_supplier',
        'nama_kontak',
        'telepon',
        'alamat',
        'tempo_bayar',
        'lama_pengiriman',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
