<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (optional, jika nama tabel mengikuti konvensi Laravel, ini bisa dihilangkan)
    protected $table = 'learnings';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'theme_id',
        'user_kelas',
        'element',
        'goals',
        'cover_image',
    ];

    // Casting tipe data
    protected $casts = [
        'cover_image' => 'string',
    ];

    // Accessor untuk mendapatkan URL lengkap cover image
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    // Definisikan relasi ke model Theme
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // Definisikan relasi ke model Module
    public function modules()
    {
        return $this->hasMany(Module::class, 'learning_id');
    }

    // Misalnya, jika relasi ke User adalah seperti ini:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
