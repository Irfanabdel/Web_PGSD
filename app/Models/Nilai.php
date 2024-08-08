<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'mapel', 'nilai', 'nama_sekolah', 'alamat_sekolah', 'projek_1', 'projek_2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'nilai_id');
    }
}

