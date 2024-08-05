<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NilaiViewController extends Controller
{
  
    public function showChart()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = Nilai::find($nilai->id);
        // Ambil data nilai berdasarkan ID pengguna yang sedang login
        $nilaiData = Nilai::where('user_id', $user_id)->get();
        
        // Persiapkan array untuk data chart nilai
        $chartData = [];
        
        // Loop melalui data nilai
        foreach ($nilaiData as $nilai) {
            // Masukkan data nilai ke dalam array chartData
            $chartData[] = [
                'label' => $nilai->label,
                'value1' => $nilai->nilai_mapel_1,
                'value2' => $nilai->nilai_mapel_2,
                'value3' => $nilai->nilai_mapel_3,
                'nama_sekolah' => $nilai->nama_sekolah,
                'alamat_sekolah' => $nilai->alamat_sekolah,
                'projek_1' => $nilai->projek_1,
                'projek_2' => $nilai->projek_2,
            ];
        }
        
        // Definisikan variabel $labels
        $labels = [
            'Nilai Mapel 1' => 'Berempati kepada orang lain',
            'Nilai Mapel 2' => 'Pemahaman Agama/Kepercayaan',
            'Nilai Mapel 3' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan'
        ];
        
        // Ambil data user (pengguna)
        $user = auth()->user();
        
        // Inisialisasi $userData dengan array kosong
        $userData = [];
        
        // Jika user tidak kosong, tambahkan informasi pengguna ke dalam array user
        if ($user) {
            $userData = [
                'Nama' => $user->name,
                'Kelas' => $user->kelas
            ];
        }
        
        // Kembalikan view dengan data yang diperlukan, termasuk variabel $labels
        return view('nilai.chart', compact('userData', 'chartData', 'labels'));
    }
}