
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('kode_supplier');
            $table->string('nama_supplier');
            $table->string('nama_kontak')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();

            $table->unsignedInteger('tempo_bayar')->default(0);
            $table->unsignedInteger('lama_pengiriman')->default(0);

            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'kode_supplier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
