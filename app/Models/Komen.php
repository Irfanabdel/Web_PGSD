<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;


class Komen extends Model
{
    use HasFactory;
    use Commentable;
    protected $table = 'komen';

}


