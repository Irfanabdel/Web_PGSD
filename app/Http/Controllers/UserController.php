<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import model User

class UserController extends Controller
{
    public function index()
    {
        // Ambil data user dari database
        $users = User::all();
    
        // Kirim data user ke view
        return view('user.index', ['users' => $users]);
    }
}
