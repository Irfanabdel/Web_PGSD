<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\User;


class ChartController extends Controller
{
 


    public function showChart($idNilai)
    {
        // Ambil data nilai berdasarkan ID nilai
        $nilai = Nilai::findOrFail($idNilai);
    
        // Ambil pengguna yang sedang login
        $user = auth()->user();
    
        // Jika pengguna adalah guru, mereka memiliki akses ke semua data
        if ($user->hasRole('guru')) {
            // Ambil data pengguna (siswa) berdasarkan user_id pada data nilai
            $userData = User::findOrFail($nilai->user_id);
    
            // Persiapkan array untuk data chart nilai
            $chartData = [
                [
                    'label' => 'Nilai Mapel 1',
                    'value1' => $nilai->nilai_mapel_1,
                ],
                [
                    'label' => 'Nilai Mapel 2',
                    'value2' => $nilai->nilai_mapel_2,
                ],
                [
                    'label' => 'Nilai Mapel 3',
                    'value3' => $nilai->nilai_mapel_3,
                ],
            ];
    
            // Definisikan variabel $labels
            $labels = [
                'Nilai Mapel 1' => 'Berempati kepada orang lain',
                'Nilai Mapel 2' => 'Pemahaman Agama/Kepercayaan',
                'Nilai Mapel 3' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan'
            ];
    
            // Kemudian kembalikan view dengan data yang diperlukan, termasuk variabel $userData dan $labels
            return view('nilai.chart', compact('userData', 'chartData', 'labels'));
        }
        
        // Jika pengguna adalah siswa, mereka hanya memiliki akses ke data mereka sendiri
        elseif ($user->hasRole('siswa')) {
            // Periksa apakah nilai tersebut dimiliki oleh siswa yang sedang login
            if ($nilai->user_id == $user->id) {
                // Persiapkan array untuk data chart nilai
                $chartData = [
                    [
                        'label' => 'Nilai Mapel 1',
                        'value1' => $nilai->nilai_mapel_1,
                    ],
                    [
                        'label' => 'Nilai Mapel 2',
                        'value2' => $nilai->nilai_mapel_2,
                    ],
                    [
                        'label' => 'Nilai Mapel 3',
                        'value3' => $nilai->nilai_mapel_3,
                    ],
                ];
    
                // Definisikan variabel $labels
                $labels = [
                    'Nilai Mapel 1' => 'Berempati kepada orang lain',
                    'Nilai Mapel 2' => 'Pemahaman Agama/Kepercayaan',
                    'Nilai Mapel 3' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan'
                ];
    
                // Kemudian kembalikan view dengan data yang diperlukan, termasuk variabel $user (bukan $userData) dan $labels
                return view('nilai.chart', compact('user', 'chartData', 'labels'));
            } else {
                // Jika nilai tersebut tidak dimiliki oleh siswa yang sedang login, kembalikan ke halaman sebelumnya
                return back()->with('error', 'Anda tidak memiliki izin untuk mengakses nilai ini.');
            }
        } else {
            // Jika pengguna bukan guru atau siswa, kembalikan ke halaman sebelumnya
            return back()->with('error', 'Anda tidak memiliki izin untuk mengakses nilai ini.');
        }
    }
    
    
    

      
       

   

    // Controller
    public function showSiswaNilai()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = auth()->id();

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
