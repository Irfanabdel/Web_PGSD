<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->json('student_files')->nullable()->after('videos'); // Menambahkan kolom student_files
            $table->json('student_files_titles')->nullable()->after('student_files'); // Menambahkan kolom student_files_titles
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('student_files');
            $table->dropColumn('student_files_titles');
        });
    }
};
