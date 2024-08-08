<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nilai_id', 'name', 'nilai'
    ];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }
}

