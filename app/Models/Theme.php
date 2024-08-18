<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $table = 'themes';

    protected $fillable = [
        'title',
        'dimensions',
        'project1',
        'project2',
    ];

    protected $casts = [
        'dimensions' => 'array', // Cast dimensions sebagai array
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Konversi ID dimensi ke teks yang dapat dibaca.
     */
    public function getDimensionsTextAttribute()
    {
        $dimensionMap = [
            1 => 'Beriman dan Bertaqwa Kepada Tuhan YME dan Berakhlak Mulia',
            2 => 'Berkebinekaan Global',
            3 => 'Bergotong Royong',
            4 => 'Kreatif',
            5 => 'Mandiri',
            6 => 'Bernalar Kritis',
        ];

        // Pastikan dimensions adalah array
        $dimensions = is_array($this->dimensions) ? $this->dimensions : json_decode($this->dimensions, true);

        // Konversi ID dimensi menjadi teks
        $dimensionTexts = array_map(function ($dimension) use ($dimensionMap) {
            return $dimensionMap[$dimension] ?? 'Unknown';
        }, $dimensions);

        // Gabungkan teks menjadi string yang dipisahkan dengan baris baru
        return implode("<br>", $dimensionTexts);
    }
}
