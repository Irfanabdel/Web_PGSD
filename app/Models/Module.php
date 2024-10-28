<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'learning_id', // Foreign key yang benar untuk relasi dengan Learning
        'title', // Judul modul
        'links', // Array link
        'videos', // Array video
        'student_files', // Array file siswa
        'student_files_titles', // Array judul file siswa
    ];

    // Cast atribut JSON menjadi array secara otomatis
    protected $casts = [
        'links' => 'array',
        'videos' => 'array',
        'student_files' => 'array', 
        'student_files_titles' => 'array',
    ];

    /**
     * Relasi dengan model Learning.
     * Satu modul milik satu sesi pembelajaran.
     */
    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }

    /**
     * Relasi dengan model Evaluation.
     * Satu modul dapat memiliki banyak evaluasi.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'module_id');
    }
}
