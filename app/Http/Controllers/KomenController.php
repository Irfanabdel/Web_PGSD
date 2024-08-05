<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use Illuminate\Http\Request;

class KomenController extends Controller
{
    public function index()
    {
        $komen = Komen::all();
        return view('nilai.komen', compact('komen'));
    }

}
