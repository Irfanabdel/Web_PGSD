<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Tabel yang digunakan
    protected $table = 'teachers';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'theme_id',
        'user_kelas',
        'description',
        'files',
    ];

    // Secara otomatis meng-cast kolom 'files' sebagai array (JSON handling)
    protected $casts = [
        'files' => 'array',
    ];

    /**
     * Relasi dengan model Theme (Many-to-One).
     * Satu guru (Teacher) memiliki satu tema.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Fungsi accessor untuk mendapatkan path file dalam format URL.
     * Setiap path diubah agar bisa diakses secara publik.
     */
    public function getFilesUrlAttribute()
    {
        return collect($this->files)->map(function ($file) {
            return asset(str_replace('public/', 'storage/', $file));
        });
    }
}
