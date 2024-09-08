<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Learning;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Menyimpan data formulir pembelajaran (Langkah 2).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStep2(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
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

        // Menyimpan data pembelajaran jika belum ada
        if (!isset($learningData['id'])) {
            try {
                $learning = Learning::create([
                    'theme_id' => $learningData['theme_id'],
                    'user_kelas' => $learningData['user_kelas'],
                    'element' => $learningData['element'],
                    'goals' => $learningData['goals'],
                    'cover_image' => $learningData['cover_image'],
                ]);

                // Update data sesi dengan ID pembelajaran yang baru dibuat
                $learningData['id'] = $learning->id;
                $request->session()->put('learning_data', $learningData);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan data pembelajaran. Silakan coba lagi.');
            }
        }

        // Menyimpan file modul utama jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
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
        $studentFilesPaths = [];
        if ($request->hasFile('student_files')) {
            foreach ($request->file('student_files') as $file) {
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

        // Menyimpan data modul ke database
        try {
            Module::create([
                'learnings_id' => $learningData['id'], // Menggunakan ID pembelajaran dari sesi
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

    public function updateStep2(Request $request, Module $module)
    {
        // Validasi data
        $validatedData = $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'student_files' => 'nullable|array',
            'student_files.*' => 'file|mimes:pdf,doc,docx,ppt,pptx',
            'student_files_titles' => 'nullable|array',
            'student_files_titles.*' => 'nullable|string|max:255',
            'existing_student_files' => 'nullable|array', // Tambahkan validasi untuk file siswa yang ada
        ]);

        // Menyimpan atau memperbarui file modul guru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($module->file && Storage::disk('public')->exists($module->file)) {
                Storage::disk('public')->delete($module->file);
            }

            // Simpan file baru dengan nama asli
            $file = $request->file('file');
            $filePath = $file->storeAs('modules_files', $file->getClientOriginalName(), 'public');
            $module->file = $filePath;
        }

        // Mengelola file siswa lama dan baru
        $existingStudentFiles = $module->student_files ?? [];
        $newStudentFiles = [];
        $studentFilesTitles = $request->input('student_files_titles', []);
        $existingStudentFilesInput = $request->input('existing_student_files', []);

        // Simpan file baru dengan nama asli
        if ($request->hasFile('student_files')) {
            foreach ($request->file('student_files') as $file) {
                $filePath = $file->storeAs('student_files', $file->getClientOriginalName(), 'public');
                $newStudentFiles[] = $filePath;
            }
        }

        // Periksa dan hapus file yang dihapus oleh pengguna
        $finalStudentFiles = [];
        $finalStudentFilesTitles = [];

        foreach ($existingStudentFiles as $index => $existingFile) {
            // Jika file tetap dipertahankan oleh pengguna
            if (in_array($existingFile, $existingStudentFilesInput)) {
                $finalStudentFiles[] = $existingFile;

                // Pastikan indeks $index ada di $studentFilesTitles sebelum mengaksesnya
                if (isset($studentFilesTitles[$index])) {
                    $finalStudentFilesTitles[] = $studentFilesTitles[$index];
                } else {
                    // Jika tidak ada judul yang sesuai, tambahkan judul kosong atau sesuai kebutuhan
                    $finalStudentFilesTitles[] = '';
                }
            } else {
                // Hapus file yang tidak dipertahankan
                if (Storage::disk('public')->exists($existingFile)) {
                    Storage::disk('public')->delete($existingFile);
                }
            }
        }

        // Gabungkan file lama yang dipertahankan dengan file baru
        $finalStudentFiles = array_merge($finalStudentFiles, $newStudentFiles);
        $finalStudentFilesTitles = array_merge($finalStudentFilesTitles, array_slice($studentFilesTitles, count($finalStudentFilesTitles)));

        // Update module data
        $module->student_files = $finalStudentFiles;
        $module->student_files_titles = $finalStudentFilesTitles;

        // Menyimpan atau memperbarui link
        $module->links = $request->input('links', []);

        // Menyimpan atau memperbarui video
        $module->videos = $request->input('videos', []);

        // Simpan perubahan ke database
        $module->save();

        // Redirect kembali ke halaman detail pembelajaran
        return redirect()->route('learnings.show', $module->learnings_id)->with('success', 'Data pembelajaran berhasil diperbarui.');
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
