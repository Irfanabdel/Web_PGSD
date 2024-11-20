<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Tampilkan daftar semua modul.
     */
    public function index()
    {
        // Ambil semua modul guru dengan relasi tema
        $teachers = Teacher::with('theme')->get();

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Tampilkan form untuk membuat modul guru.
     */
    public function create()
    {
        $users = User::all();
        $kelas = $users->pluck('kelas')->unique()->sort()->values();
        $themes = Theme::all();

        return view('teachers.create', compact('themes', 'kelas'));
    }

    /**
     * Menyimpan modul ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'user_kelas' => 'required|string',
            'description' => 'required|string|max:525',
            'files' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Validasi satu file saja
        ]);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('files')) {
            try {
                $filePath = $request->file('files')->storeAs(
                    'modules_files', // Direktori penyimpanan
                    $request->file('files')->getClientOriginalName(), // Nama asli file
                    'public' // Disk penyimpanan
                );
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah file modul guru. Silahkan coba lagi.');
            }
        }

        // Buat record Teacher
        Teacher::create([
            'theme_id' => $validatedData['theme_id'],
            'user_kelas' => $validatedData['user_kelas'],
            'description' => $validatedData['description'],
            'files' => $filePath, // Simpan path file atau null jika tidak ada
        ]);

        return redirect()->route('teachers.index')->with('success', 'Modul guru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit modul guru.
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id); // Cari modul berdasarkan ID atau gagal jika tidak ditemukan
        $themes = Theme::all(); // Ambil semua tema
        $users = User::all();
        $kelas = $users->pluck('kelas')->unique()->sort()->values(); // Kumpulkan kelas unik

        return view('teachers.edit', compact('teacher', 'themes', 'kelas'));
    }

    /**
     * Update modul guru di database.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id); // Cari modul berdasarkan ID atau gagal jika tidak ditemukan

        // Validasi input
        $validatedData = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'user_kelas' => 'required|string',
            'description' => 'required|string',
            'files' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Validasi untuk satu file saja
        ]);

        // Simpan file baru jika diunggah dan hapus file lama jika ada
        if ($request->hasFile('files')) {
            // Hapus file lama jika ada
            if ($teacher->files && Storage::exists('public/' . $teacher->files)) {
                Storage::delete('public/' . $teacher->files);
            }

            try {
                // Simpan file baru
                $filePath = $request->file('files')->storeAs(
                    'modules_files',
                    $request->file('files')->getClientOriginalName(),
                    'public'
                );
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah file modul guru. Silahkan coba lagi.');
            }

            $teacher->files = $filePath; // Simpan path file baru
        }

        // Update data modul guru
        $teacher->update([
            'theme_id' => $validatedData['theme_id'],
            'user_kelas' => $validatedData['user_kelas'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('teachers.index')->with('success', 'Modul guru berhasil diperbarui.');
    }

    /**
     * Hapus modul guru dari database dan hapus file terkait jika ada.
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id); // Temukan modul berdasarkan ID atau gagal jika tidak ditemukan

        // Hapus file jika ada
        if ($teacher->files && Storage::exists('public/' . $teacher->files)) {
            Storage::delete('public/' . $teacher->files);
        }

        // Hapus data modul dari database
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Modul guru berhasil dihapus.');
    }
}
