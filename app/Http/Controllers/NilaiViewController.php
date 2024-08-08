<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiViewController extends Controller
{
    public function showChart()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = Auth::id();
        
        // Ambil data nilai berdasarkan ID pengguna yang sedang login
        $nilaiData = Nilai::where('user_id', $user_id)->first();

        if (!$nilaiData) {
            // Jika data nilai tidak ditemukan, redirect atau tampilkan pesan
            return redirect('/dashboard')->with('error', 'Data nilai tidak ditemukan');
        }

        // Ambil semua data mapel
        $mapelData = Mapel::all();
        
        // Persiapkan array untuk data chart nilai
        $chartData = [];

        // Loop melalui data mapel untuk mendapatkan nilai
        foreach ($mapelData as $mapel) {
            $chartData[] = [
                'label' => $mapel->name,
                'nilai' => $nilaiData->{"nilai_mapel_{$mapel->id}"} ?? null,
                'nama_sekolah' => $nilaiData->nama_sekolah,
                'alamat_sekolah' => $nilaiData->alamat_sekolah,
                'projek_1' => $nilaiData->projek_1,
                'projek_2' => $nilaiData->projek_2,
            ];
        }

        // Ambil data user (pengguna)
        $user = Auth::user();
        
        // Inisialisasi $userData dengan array kosong
        $userData = [];
        
        // Jika user tidak kosong, tambahkan informasi pengguna ke dalam array user
        if ($user) {
            $userData = [
                'Nama' => $user->name,
                'Kelas' => $user->kelas,
            ];
        }
        
        // Kembalikan view dengan data yang diperlukan
        return view('nilai.chart', compact('userData', 'chartData'));
    }
}
