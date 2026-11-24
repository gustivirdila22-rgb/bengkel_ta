
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->cascadeOnDelete();

            $table->string('nomor_polisi', 20);
            $table->string('merek')->nullable();
            $table->string('tipe')->nullable();
            $table->year('tahun')->nullable();
            $table->string('warna')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique('nomor_polisi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
