<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Learning;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah guru dan siswa
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahSiswa = User::where('role', 'siswa')->count();

        // Menghitung jumlah learnings berdasarkan peran pengguna
        $user = auth()->user();
        if ($user->role == 'guru') {
            $jumlahLearnings = Learning::count(); // Hitung semua learnings jika pengguna adalah guru
        } else {
            // Hitung learnings berdasarkan kelas pengguna jika pengguna adalah siswa
            $jumlahLearnings = Learning::where('user_kelas', $user->kelas)->count();
        }

        // Mengembalikan tampilan dengan data jumlah
        return view('dashboard', [
            'jumlahGuru' => $jumlahGuru,
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahLearnings' => $jumlahLearnings
        ]);
    }
}
