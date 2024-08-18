<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Tampilkan daftar semua tema.
     */
    public function index()
    {
        $themes = Theme::all();

        return view('themes.index', compact('themes'));
    }

    /**
     * Tampilkan formulir untuk membuat tema baru.
     */
    public function create()
    {
        return view('themes.create');
    }

    /**
     * Simpan tema baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'dimensions' => 'required|array',
            'dimensions.*' => 'required|in:1,2,3,4,5,6',
            'project1' => 'required|string|max:255',
            'project2' => 'required|string|max:255',
        ]);

        Theme::create([
            'title' => $request->title,
            'dimensions' => json_encode($request->dimensions),
            'project1' => $request->project1,
            'project2' => $request->project2,
        ]);

        return redirect()->route('themes.index')->with('success', 'Tema berhasil dibuat.');
    }

    /**
     * Tampilkan formulir untuk mengedit tema yang ada.
     */
    public function edit(Theme $theme)
    {
        // Ambil dimensi dalam format ID
        $dimensions = $theme->dimensions;

        // Konversi dimensi ID ke teks
        $convertedDimensions = $theme->dimensions_text;

        return view('themes.edit', compact('theme', 'convertedDimensions'));
    }

    /**
     * Perbarui tema yang ada di dalam database.
     */
    public function update(Request $request, Theme $theme)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'dimensions' => 'required|array',
            'dimensions.*' => 'required|in:1,2,3,4,5,6',
            'project1' => 'required|string|max:255',
            'project2' => 'required|string|max:255',
        ]);

        $theme->update([
            'title' => $request->title,
            'dimensions' => json_encode($request->dimensions),
            'project1' => $request->project1,
            'project2' => $request->project2,
        ]);

        return redirect()->route('themes.index')->with('success', 'Tema berhasil diperbarui.');
    }

    /**
     * Hapus tema dari database.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()->route('themes.index')->with('success', 'Tema berhasil dihapus.');
    }
}

