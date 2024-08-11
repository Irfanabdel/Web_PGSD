<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;


class ChartController extends Controller
{
    public function showSiswaNilai()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = Auth::id();

        // Ambil data nilai berdasarkan ID pengguna yang sedang login
        $nilaiData = Nilai::with('mapels')->where('user_id', $user_id)->first();

        if (!$nilaiData) {
            // Jika data nilai tidak ditemukan, arahkan ke halaman 'nilai.empty'
            return redirect()->route('nilai.empty')->with('error', 'Data nilai tidak ditemukan');
        }

        // Persiapkan array untuk data chart nilai
        $chartData = [];
        $nilaiSeries = [];
        $mapelLabels = [];

        // Loop melalui data mapel untuk mendapatkan nilai dan label mapel
        foreach ($nilaiData->mapels as $mapel) {
            $nilaiSeries[] = $mapel->nilai;
            $mapelLabels[] = $mapel->name;
        }

        // Ambil data user (pengguna)
        $user = Auth::user();

        // Inisialisasi $userData
        $userData = [
            'Nama' => $user->name,
            'Kelas' => $user->kelas, // pastikan 'kelas' adalah atribut yang valid pada model User
        ];

        // Ambil informasi sekolah dan proyek
        $schoolData = [
            'nama_sekolah' => $nilaiData->nama_sekolah,
            'alamat_sekolah' => $nilaiData->alamat_sekolah,
            'projek_1' => $nilaiData->projek_1,
            'projek_2' => $nilaiData->projek_2,
        ];

        // Debugging data
        #dd(compact('userData', 'schoolData', 'nilaiSeries', 'mapelLabels'));

        // Kembalikan view dengan data yang diperlukan untuk chart
        return view('nilai.chart', compact('userData', 'schoolData', 'nilaiSeries', 'mapelLabels'));
    }
}
