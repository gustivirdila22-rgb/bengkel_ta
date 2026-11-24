<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JasaServis extends Model
{
    protected $table = 'jasa_servis';

    protected $fillable = [
        'kode_jasa',
        'nama',
        'kategori_jasa_id',
        'estimasi_menit',
        'harga_standar',
        'modal',
        'keterangan',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'estimasi_menit' => 'integer',
            'harga_standar' => 'integer',
            'modal' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            KategoriJasa::class,
            'kategori_jasa_id'
        );
    }
}
