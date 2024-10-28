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
        Schema::table('evaluations', function (Blueprint $table) {
            $table->string('file_name')->nullable(); // Menambahkan kolom untuk menyimpan nama file
            $table->string('file_url')->nullable();  // Menambahkan kolom untuk menyimpan URL file
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'file_url']); // Menghapus kolom file_name dan file_url jika migrasi di-revert
        });
    }
};
