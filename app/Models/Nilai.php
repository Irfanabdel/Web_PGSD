<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'mapel', 'nilai', 'projek_1', 'projek_2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'nilai_id');
    }

    // Menambahkan akses untuk school_name dari relasi user
    public function getSchoolNameAttribute()
    {
        return $this->user ? $this->user->school_name : null;
    }
}

