<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'evaluation_id',
        'user_id',
        'answers',
    ];

    /**
     * Get the evaluation that owns the work.
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    /**
     * Get the user that owns the work.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
