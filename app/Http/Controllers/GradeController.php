<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\User;
use App\Models\Theme;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['user', 'theme'])->get();
        $themesExist = Theme::count() > 0; // Cek apakah ada tema

        return view('grades.index', compact('grades', 'themesExist'));
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
