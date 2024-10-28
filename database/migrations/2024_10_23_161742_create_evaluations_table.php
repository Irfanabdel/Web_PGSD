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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id(); // Kolom ID untuk tabel evaluations
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade'); // Menghubungkan ke tabel activities
            $table->string('title'); // Kolom untuk judul evaluasi
            $table->text('description')->nullable(); // Kolom untuk deskripsi evaluasi
            $table->dateTime('start_datetime')->nullable(); // Kolom untuk tanggal dan waktu mulai
            $table->dateTime('end_datetime')->nullable(); // Kolom untuk tanggal dan waktu berakhir
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
