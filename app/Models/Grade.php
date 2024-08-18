<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'user_id',
        'theme_id',
        'assessments',
    ];

    protected $casts = [
        'assessments' => 'array', // Cast assessments sebagai array
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Theme
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Konversi nilai assessments ke format kategorikal.
     */
    public function getAssessmentsTextAttribute()
    {
        $assessmentMap = [
            1 => 'BB',
            2 => 'MB',
            3 => 'BSH',
            4 => 'SB',
        ];

        // Pastikan assessments adalah array
        $assessments = is_array($this->assessments) ? $this->assessments : json_decode($this->assessments, true);

        // Konversi nilai assessments menjadi teks
        $assessmentTexts = array_map(function ($assessment) use ($assessmentMap) {
            return $assessmentMap[$assessment] ?? 'Unknown';
        }, $assessments);

        // Gabungkan teks menjadi string yang dipisahkan dengan baris baru
        return implode("<br>", $assessmentTexts);
    }
}
