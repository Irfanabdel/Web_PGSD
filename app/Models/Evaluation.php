<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evaluation extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (optional, jika nama tabel mengikuti konvensi Laravel, ini bisa dihilangkan)
    protected $table = 'evaluations';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'learning_id',
        'module_id',
        'title',
        'description',
        'start_datetime',
        'end_datetime',
    ];

    // Casting tipe data (jika diperlukan)
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    // Aksesors untuk mengonversi waktu ke zona waktu Asia/Jakarta
    public function getStartDatetimeAttribute($value)
    {
        return Carbon::parse($value, 'UTC')->setTimezone('Asia/Jakarta');
    }

    public function getEndDatetimeAttribute($value)
    {
        return Carbon::parse($value, 'UTC')->setTimezone('Asia/Jakarta');
    }

    // Mutators untuk menyimpan waktu dalam zona waktu UTC
    public function setStartDatetimeAttribute($value)
    {
        $this->attributes['start_datetime'] = Carbon::parse($value, 'Asia/Jakarta')->setTimezone('UTC')->toDateTimeString();
    }

    public function setEndDatetimeAttribute($value)
    {
        $this->attributes['end_datetime'] = Carbon::parse($value, 'Asia/Jakarta')->setTimezone('UTC')->toDateTimeString();
    }

    // Definisikan relasi ke model Learning
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Definisikan relasi ke model Work
    public function works()
    {
        return $this->hasMany(Work::class);
    }

    // Definisikan relasi ke model Learning
    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
}