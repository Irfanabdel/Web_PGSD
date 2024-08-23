<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'learnings_id', // ID dari Learning
        'file', // Nama file yang diunggah
        'links', // Array links
        'videos', // Array videos
        'student_files', // Array file pembelajaran siswa
        'student_files_titles', // Array judul file pembelajaran siswa
    ];

    protected $casts = [
        'links' => 'array',
        'videos' => 'array',
        'student_files' => 'array', // Cast untuk file pembelajaran siswa sebagai array
        'student_files_titles' => 'array', // Cast untuk judul file pembelajaran siswa sebagai array
    ];

    /**
     * Mendapatkan pembelajaran yang memiliki modul ini.
     */
    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learnings_id');
    }
}


