<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\User;
use App\Models\Theme;
use Carbon\Carbon;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter sorting dari query string
        $sortBy = $request->input('sort_by', 'updated_at'); // Default sort by 'updated_at'
        $sortOrder = $request->input('sort_order', 'desc'); // Default order is descending

        // Validasi parameter sorting
        $validSortBy = ['name', 'school_name', 'kelas', 'updated_at'];
        $validSortOrder = ['asc', 'desc'];

        if (!in_array($sortBy, $validSortBy)) {
            $sortBy = 'updated_at';
        }

        if (!in_array($sortOrder, $validSortOrder)) {
            $sortOrder = 'desc';
        }

        // Ambil semua nilai dengan relasi 'user' dan 'theme', lalu urutkan berdasarkan parameter
        $grades = Grade::with(['user', 'theme'])
            ->when($sortBy === 'name', function ($query) use ($sortOrder) {
                // Sorting berdasarkan kolom 'name' di tabel 'users'
                $query->join('users', 'grades.user_id', '=', 'users.id')
                    ->orderBy('users.name', $sortOrder);
            })
            ->when($sortBy === 'school_name', function ($query) use ($sortOrder) {
                // Sorting berdasarkan kolom 'school_name' di tabel 'users'
                $query->join('users', 'grades.user_id', '=', 'users.id')
                    ->orderBy('users.school_name', $sortOrder);
            })
            ->when($sortBy === 'kelas', function ($query) use ($sortOrder) {
                // Sorting berdasarkan kolom 'kelas' di tabel 'users'
                $query->join('users', 'grades.user_id', '=', 'users.id')
                    ->orderBy('users.kelas', $sortOrder);
            })
            ->when($sortBy === 'updated_at', function ($query) use ($sortOrder) {
                // Sorting berdasarkan kolom 'updated_at' di tabel 'grades'
                $query->orderBy('grades.updated_at', $sortOrder);
            })
            ->get();

        // Ambil ID tema yang sudah memiliki nilai
        $themeIdsWithGrades = $grades->pluck('theme_id')->unique();

        // Ambil tema yang ID-nya ada dalam daftar tema dengan nilai dan urutkan berdasarkan ID tema
        $themes = Theme::whereIn('id', $themeIdsWithGrades)
            ->orderBy('id')
            ->get();

        // Cek apakah ada tema
        $themesExist = $themes->isNotEmpty();

        // Format tanggal update dengan zona waktu Asia/Jakarta
        $grades->each(function ($grade) {
            $grade->updated_at = Carbon::parse($grade->updated_at)->setTimezone('Asia/Jakarta');
        });

        return view('grades.index', compact('grades', 'themes', 'themesExist', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $themes = Theme::all();

        return view('grades.create', compact('users', 'themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme_id' => 'required|exists:themes,id',
            'assessments' => 'required|array',
            'assessments.*' => 'required|in:1,2,3,4', // Validasi sesuai dengan format yang diharapkan
        ]);

        $user_id = $request->input('user_id');
        $theme_id = $request->input('theme_id');
        $assessments = $request->input('assessments');

        // Simpan data nilai
        $grade = new Grade([
            'user_id' => $user_id,
            'theme_id' => $theme_id,
            'assessments' => json_encode($assessments), // Simpan sebagai JSON string
        ]);

        $grade->save();

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil disimpan!');
    }

    public function edit(Grade $grade)
    {
        $users = User::where('role', 'siswa')->get();
        $themes = Theme::all();

        return view('grades.edit', compact('grade', 'users', 'themes'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme_id' => 'required|exists:themes,id',
            'assessments' => 'required|array',
            'assessments.*' => 'required|in:1,2,3,4', // Validasi sesuai dengan format yang diharapkan
        ]);

        $grade->user_id = $request->input('user_id');
        $grade->theme_id = $request->input('theme_id');
        $grade->assessments = json_encode($request->input('assessments'));

        $grade->save();

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil diperbarui!');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil dihapus!');
    }

    // Menambahkan method untuk mendapatkan dimensi tema berdasarkan ID
    public function getThemeDimensions($themeId)
    {
        $theme = Theme::find($themeId);

        if ($theme) {
            return response()->json([
                'project1' => $theme->project1,
                'project2' => $theme->project2,
                'dimensions' => $theme->dimensions // Pastikan `dimensions` adalah array atau string JSON
            ]);
        }

        return response()->json(['error' => 'Tema tidak ditemukan'], 404);
    }
}
