<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    
    protected $fillable = [
        'user_id',
        'label',
        'nilai_mapel_1',
        'nilai_mapel_2',
        'nilai_mapel_3',
        'nama_sekolah',
        'alamat_sekolah',
        'projek_1',
        'projek_2',
    ];
    

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
