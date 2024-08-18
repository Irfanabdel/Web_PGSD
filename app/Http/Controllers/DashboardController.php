<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah guru dan siswa
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahSiswa = User::where('role', 'siswa')->count();

        // Mengembalikan tampilan dengan data jumlah
        return view('dashboard', compact('jumlahGuru', 'jumlahSiswa'));
    }
}
