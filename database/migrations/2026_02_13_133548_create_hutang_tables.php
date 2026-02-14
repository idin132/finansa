<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hutang');
            $table->string('pihak_pemberi');
            $table->decimal('nilai_pokok', 15, 2);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_tempo')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('hutang_bayar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hutang')->constrained('hutang')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('nominal', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_tables');
    }
};
