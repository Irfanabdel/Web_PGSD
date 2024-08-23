<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Learning;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Menampilkan halaman formulir untuk langkah kedua.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function storeStep2(Request $request)
    {
        // Validasi data
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // 10MB max file size
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'student_files' => 'nullable|array',
            'student_files.*' => 'file|mimes:pdf,doc,docx,ppt,pptx', // Validasi file siswa
            'student_files_titles' => 'nullable|array',
            'student_files_titles.*' => 'nullable|string|max:255', // Validasi judul file siswa
        ]);

        // Ambil data dari sesi
        $learningData = session('learning_data');

        if (!$learningData || !isset($learningData['learnings_id'])) {
            return redirect()->route('learnings.create')->with('error', 'Data pembelajaran tidak ditemukan. Silakan mulai ulang.');
        }

        // Menyimpan file modul utama jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            try {
                // Simpan file dengan nama asli
                $filePath = $request->file('file')->storeAs(
                    'modules_files',
                    $request->file('file')->getClientOriginalName(),
                    'public'
                );
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }
        }

        // Menyimpan file siswa jika ada
        $studentFilesPaths = [];
        if ($request->hasFile('student_files')) {
            foreach ($request->file('student_files') as $file) {
                try {
                    // Simpan setiap file siswa dengan nama asli
                    $studentFilesPaths[] = $file->storeAs(
                        'student_files',
                        $file->getClientOriginalName(),
                        'public'
                    );
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal mengunggah salah satu file siswa. Silakan coba lagi.');
                }
            }
        }

        // Menyimpan data modul ke database
        try {
            Module::create([
                'learnings_id' => $learningData['learnings_id'],
                'file' => $filePath,
                'links' => $request->input('links', []),
                'videos' => $request->input('videos', []),
                'student_files' => $studentFilesPaths,
                'student_files_titles' => $request->input('student_files_titles', []),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data modul. Silakan coba lagi.');
        }

        // Hapus data dari sesi setelah penyimpanan
        $request->session()->forget('learning_data');

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('learnings.index')->with('success', 'Modul berhasil disimpan!');
    }

    /**
     * Menampilkan halaman edit untuk pembelajaran (Langkah 2 - Modul).
     *
     * @param \App\Models\Learning $learning
     * @return \Illuminate\View\View
     */
    public function editStep2(Learning $learning)
    {
        $modules = Module::where('learnings_id', $learning->id)->get();
        // Mengambil modul pertama untuk diedit (misalnya, jika Anda ingin mengedit modul tertentu)
        $module = $modules->first(); // Atau dapatkan modul sesuai kebutuhan

        // Mengembalikan view dengan data yang diperlukan
        return view('learnings.edit.step2', [
            'learning' => $learning,
            'modules' => $modules,
            'module' => $module,
        ]);
    }

    /**
     * Memperbarui data modul (Langkah 2).
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Learning $learning
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStep2(Request $request, Module $module)
    {
        // Validasi data
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'student_files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'student_files_titles.*' => 'nullable|string|max:255',
            'links.*' => 'nullable|url',
            'videos.*' => 'nullable|url',
        ]);

        // Menyimpan file modul utama jika ada
        $filePath = $module->file;
        if ($request->hasFile('file')) {
            if ($module->file && Storage::disk('public')->exists($module->file)) {
                Storage::disk('public')->delete($module->file);
            }
            try {
                $filePath = $request->file('file')->storeAs(
                    'modules_files',
                    $request->file('file')->getClientOriginalName(),
                    'public'
                );
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah file modul. Silakan coba lagi.');
            }
        }

        // Menyimpan file siswa jika ada
        $studentFilesPaths = $module->student_files;
        if ($request->hasFile('student_files')) {
            $studentFilesPaths = [];
            foreach ($request->file('student_files') as $index => $file) {
                try {
                    $studentFilesPaths[] = $file->storeAs(
                        'student_files',
                        $file->getClientOriginalName(),
                        'public'
                    );
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal mengunggah salah satu file siswa. Silakan coba lagi.');
                }
            }
        }

        // Update data modul
        try {
            $module->update([
                'file' => $filePath,
                'links' => $request->input('links', []),
                'videos' => $request->input('videos', []),
                'student_files' => $studentFilesPaths,
                'student_files_titles' => $request->input('student_files_titles', []),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data modul. Silakan coba lagi.');
        }

        return redirect()->route('learnings.index')->with('success', 'Data langkah 2 berhasil diperbarui.');
    }

    /**
     * Menghapus data modul (Langkah 2).
     *
     * @param \App\Models\Module $module
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Module $module)
    {
        // Hapus file modul utama jika ada
        if ($module->file && Storage::disk('public')->exists($module->file)) {
            Storage::disk('public')->delete($module->file);
        }

        // Hapus file siswa jika ada
        if ($module->student_files) {
            foreach ($module->student_files as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // Hapus data modul dari database
        try {
            $module->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data modul. Silakan coba lagi.');
        }

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('learnings.index')->with('success', 'Data modul berhasil dihapus.');
    }
}
