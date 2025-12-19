<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hutang', 150)->nullable(); // Nama singkat atau deskripsi
            $table->string('pihak_pemberi', 150)->nullable(); // Nama entitas atau orang yang memberi pinjaman
            $table->decimal('nilai_pokok', 15, 2)->default(0); // Jumlah uang pokok yang dipinjam
            $table->decimal('sisa_hutang', 15, 2)->default(0); // Sisa hutang yang belum terbayar
            $table->decimal('bunga_persen', 5, 2)->nullable(); // Persentase bunga (e.g., 10.50)
            $table->decimal('total_pembayaran', 15, 2)->nullable(); // Total yang harus dibayar (pokok + bunga)
            $table->date('tanggal_pinjam')->nullable(); // Tanggal hutang dimulai
            $table->date('tanggal_tempo')->nullable(); // Tanggal jatuh tempo keseluruhan hutang
            $table->enum('status', ['Masih', 'Lunas', 'Jatuh Tempo', 'Ditangguhkan'])->default('Masih');
            $table->text('keterangan')->nullable();
            $table->integer('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang');
    }
};