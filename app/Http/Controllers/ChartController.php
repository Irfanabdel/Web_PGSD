<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Theme;

class ChartController extends Controller
{
    /**
     * Menampilkan halaman chart dengan data asesmen.
     *
     * @return \Illuminate\View\View
     */
    public function showChart()
    {
        // Ambil data pengguna yang aktif
        $user = auth()->user();

        // Ambil data nilai siswa untuk pengguna yang aktif dengan tema terkait
        $grades = Grade::where('user_id', $user->id)
            ->with('theme') // Pastikan relasi ini ada
            ->get();

        // Data untuk view
        $data = [];

        // Pemetaan nilai ke kategori BB, MB, BSH, SB
        $assessmentMap = [
            1 => 'BB',
            2 => 'MB',
            3 => 'BSH',
            4 => 'SB',
        ];

        // Proses data untuk grafik
        foreach ($grades as $grade) {
            $theme = $grade->theme;
            $dimensions = explode("<br>", $theme->dimensions_text);
            $assessments = is_array($grade->assessments) ? $grade->assessments : json_decode($grade->assessments, true);

            $dimensionLabels = $dimensions;
            $assessmentData = [];

            foreach ($dimensions as $index => $dimension) {
                $assessmentData[] = $assessmentMap[$assessments[$index] ?? null] ?? 'Unknown';
            }

            $data[$theme->title][] = [
                'dimensionLabels' => $dimensionLabels,
                'assessmentData' => $assessmentData,
                'project1' => $theme->project1,
                'project2' => $theme->project2,
                'comments_1' => $grade->comments_1, // Tambahkan comments_1
                'comments_2' => $grade->comments_2, // Tambahkan comments_2
            ];
        }

        // Data pengguna
        $userData = [
            'Nama' => $user->name,
            'school_name' => $user->school_name,
            'Kelas' => $user->kelas,
        ];

        // Kirim data ke view
        return view('grades.chart', [
            'userData' => $userData,
            'data' => $data
        ]);
    }
}
