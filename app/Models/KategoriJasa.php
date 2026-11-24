<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriJasa extends Model
{
    protected $table = 'kategori_jasa';

    protected $fillable = [
        'kode_kategori',
        'nama',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function jasaServis(): HasMany
    {
        return $this->hasMany(JasaServis::class, 'kategori_jasa_id');
    }
}
