<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = ['nama'];

    // Data mata pelajaran yang statis
    public static function staticMapels()
    {
        return [
            'Berempati kepada orang lain',
            'Pemahaman Agama/Kepercayaan',
            'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan'
        ];
    }
}
