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
        Schema::table('komen', function (Blueprint $table) {
            // Menambahkan kolom user_id setelah kolom id
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komen', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Menghapus foreign key constraint
            $table->dropColumn('user_id'); // Menghapus kolom user_id
        });
    }
};