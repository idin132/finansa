<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul catatan/event
            $table->dateTime('start'); // Tanggal dan waktu mulai (untuk FullCalendar)
            $table->dateTime('end')->nullable(); // Tanggal dan waktu selesai (opsional)
            $table->text('description')->nullable(); // Detail catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
