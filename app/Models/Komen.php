<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;

class Komen extends Model
{
    use HasFactory, Commentable;

    protected $table = 'komen';

    //Tambahkan kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'title',
        'Desc',
        'image',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}