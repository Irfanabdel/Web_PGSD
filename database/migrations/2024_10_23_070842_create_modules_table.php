<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_id')->constrained('learnings')->onDelete('cascade'); // Relasi dengan tabel learnings
            $table->string('title');
            $table->json('student_files_titles')->nullable(); // Menyimpan judul file siswa
            $table->json('student_files')->nullable(); // Menyimpan file siswa dalam JSON
            $table->json('links')->nullable(); // Menyimpan link terkait
            $table->json('videos')->nullable(); // Menyimpan video terkait
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
