<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jasa_servis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jasa')->unique();
            $table->string('nama');

            $table->foreignId('kategori_jasa_id')
                ->nullable()
                ->constrained('kategori_jasa')
                ->nullOnDelete();

            $table->unsignedInteger('estimasi_menit')->nullable();
            $table->unsignedBigInteger('harga_standar')->default(0);
            $table->unsignedBigInteger('modal')->default(0);
            $table->text('keterangan')->nullable();
            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jasa_servis');
    }
};